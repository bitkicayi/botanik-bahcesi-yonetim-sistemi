<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$sorgu = $conn->prepare("SELECT * FROM personel WHERE ekleyen_kullanici_id = ?");
$sorgu->bind_param("i", $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Personel Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Kayıtlı Personel</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>
    <?php if ($sonuc->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Ünvan</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($satir = $sonuc->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $satir["personel_id"]; ?></td>
                        <td><?php echo htmlspecialchars($satir["ad_soyad"]); ?></td>
                        <td><?php echo htmlspecialchars($satir["unvan"]); ?></td>
                        <td><?php echo htmlspecialchars($satir["telefon"]); ?></td>
                        <td><?php echo htmlspecialchars($satir["email"]); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($satir["aciklama"])); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $satir['personel_id']; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="sil.php?id=<?php echo $satir['personel_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu personeli silmek istediğinizden emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz personel kaydı eklemediniz.</div>
    <?php endif; ?>
</div> </body> </html>