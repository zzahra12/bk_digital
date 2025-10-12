<?php 
// ... (bagian atas sama)
$siswa_id = $_SESSION['users_id'];

// Query yang lebih baik: Fetch keluhan dengan balasan terbaru (jika ada)
$stmt = $pdo->prepare("
    SELECT k.id, k.keluhan_text, k.tanggal as keluhan_tanggal, k.status,
           b.balasan_text, b.tanggal as balasan_tanggal, u.nama as guru_nama
    FROM keluhan k 
    LEFT JOIN balasan b ON k.id = b.keluhan_id 
    LEFT JOIN users u ON b.guru_id = u.id 
    WHERE k.siswa_id = ? 
    ORDER BY k.tanggal DESC, b.tanggal DESC
");
$stmt->execute([$siswa_id]);
$keluhan_list = $stmt->fetchAll(PDO::FETCH_GROUP);  // Group by keluhan_id untuk multiple balasan jika perlu
?>
<!-- Di loop foreach, adjust untuk tampilkan balasan: -->
<?php foreach ($keluhan_list as $keluhan_id => $items): 
    $keluhan = $items[0];  // Keluhan pertama
?>
    <div class="keluhan">
        <h3>Keluhan (<?php echo date('d/m/Y H:i', strtotime($keluhan['keluhan_tanggal'])); ?>)</h3>
        <p><strong>Status:</strong> <?php echo ucfirst($keluhan['status']); ?></p>
        <p><?php echo nl2br($keluhan['keluhan_text']); ?></p>
        <?php foreach ($items as $item): 
            if ($item['balasan_text']): ?>
                <div class="balasan">
                    <h4>Balasan dari <?php echo htmlspecialchars($item['guru_nama']); ?> (<?php echo date('d/m/Y H:i', strtotime($item['balasan_tanggal'])); ?>)</h4>
                    <p><?php echo nl2br(htmlspecialchars($item['balasan_text'])); ?></p>
                </div>
            <?php endif; 
        endforeach; ?>
    </div>
<?php endforeach; ?>