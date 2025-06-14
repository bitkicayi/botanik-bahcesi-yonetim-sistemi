<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
// Bakım planlarını ve ilgili bitki adlarını çek
$sorgu = $conn->prepare("
    SELECT bp.*, b.bitki_ad 
    FROM bakim_planlari bp
    JOIN bitkiler b ON bp.bitki_id = b.bitki_id
    WHERE bp.ekleyen_kullanici_id = ?
    ORDER BY bp.plan_tarihi ASC
");
$sorgu->bind_param("i", $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakım Planları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bakım Planları</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>
    <?php if ($sonuc->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Bitki</th>
                    <th>İşlem Türü</th>
                    <th>Plan Tarihi</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($satir = $sonuc->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $satir["plan_id"]; ?></td>
                        <td><?php echo htmlspecialchars($satir["bitki_ad"]); ?></td>
                        <td><?php echo htmlspecialchars($satir["islem_turu"]); ?></td>
                        <td><?php echo $satir["plan_tarihi"]; ?></td>
                        <td><?php echo nl2br(htmlspecialchars($satir["aciklama"])); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $satir['plan_id']; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="sil.php?id=<?php echo $satir['plan_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu bakım planını silmek istediğinizden emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz hiç bakım planı eklenmemiş.</div>
    <?php endif; ?>
</div> </body> </html>