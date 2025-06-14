<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
// Veritabanından kullanıcıya ait bitkileri çek
$sorgu = $conn->prepare("SELECT * FROM bitkiler WHERE ekleyen_kullanici_id = ?");
$sorgu->bind_param("i", $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bitki Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Kayıtlı Bitkileriniz</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>
    <?php if ($sonuc->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Tür</th>
                    <th>Dikim Tarihi</th>
                    <th>Sulama Sıklığı</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($satir = $sonuc->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $satir["bitki_id"]; ?></td>
                        <td><?php echo htmlspecialchars($satir["bitki_ad"]); ?></td>
                        <td><?php echo htmlspecialchars($satir["bitki_tur"]); ?></td>
                        <td><?php echo $satir["bitki_dikim_tarihi"]; ?></td>
                        <td><?php echo htmlspecialchars($satir["bitki_sulama_sikligi"]); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($satir["bitki_aciklama"])); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $satir['bitki_id']; ?>" 
                               class="btn btn-sm btn-primary">
                                Düzenle
                            </a>
                            <a href="sil.php?id=<?php echo $satir['bitki_id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Bu bitkiyi silmek istediğinizden emin misiniz?');">
                                Sil
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz hiç bitki eklemediniz.</div>
    <?php endif; ?>
</div> </body> </html>