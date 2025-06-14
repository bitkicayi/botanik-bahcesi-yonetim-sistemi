<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
// Kullanıcının ziyaretçilerini çek
$sorgu = $conn->prepare("SELECT * FROM ziyaretciler WHERE ekleyen_kullanici_id = ?");
$sorgu->bind_param("i", $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ziyaretçi Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Kayıtlı Ziyaretçiler</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>
    <?php if ($sonuc->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Tarih</th>
                    <th>Neden</th>
                    <th>İletişim</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($satir = $sonuc->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $satir["ziyaretci_id"]; ?></td>
                        <td><?php echo htmlspecialchars($satir["ad_soyad"]); ?></td>
                        <td><?php echo $satir["ziyaret_tarihi"]; ?></td>
                        <td><?php echo nl2br(htmlspecialchars($satir["ziyaret_nedeni"])); ?></td>
                        <td><?php echo htmlspecialchars($satir["iletisim"]); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $satir['ziyaretci_id']; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="sil.php?id=<?php echo $satir['ziyaretci_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu ziyaretçiyi silmek istediğinizden emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz ziyaretçi kaydı yapılmamış.</div>
    <?php endif; ?>
</div> </body> </html>