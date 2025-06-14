<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
// Görevleri çek
$sorgu = $conn->prepare("
    SELECT g.*, 
           p.ad_soyad AS personel_adi
    FROM gorevler g
    JOIN personel p ON g.personel_id = p.personel_id
    WHERE g.ekleyen_kullanici_id = ?
    ORDER BY g.gorev_tarih DESC
");
$sorgu->bind_param("i", $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Görev Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Tanımlanmış Görevler</h2>
    <a href="ekle.php" class="btn btn-success mb-3">➕ Yeni Görev Ekle</a>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>
    <?php if (isset($_GET['silme']) && $_GET['silme'] === 'ok'): ?>
        <div class="alert alert-success">Görev başarıyla silindi.</div>
    <?php endif; ?>
    <?php if ($sonuc->num_rows > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Görev Adı</th>
                    <th>Tip</th>
                    <th>Hedef ID</th>
                    <th>Personel</th>
                    <th>Tarih</th>
                    <th>Açıklama</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($satir = $sonuc->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($satir['gorev_ad']); ?></td>
                        <td><?php echo $satir['gorev_tipi']; ?></td>
                        <td><?php echo $satir['hedef_id']; ?></td>
                        <td><?php echo htmlspecialchars($satir['personel_adi']); ?></td>
                        <td><?php echo $satir['gorev_tarih']; ?></td>
                        <td><?php echo nl2br(htmlspecialchars($satir['aciklama'])); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $satir['gorev_id']; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="sil.php?id=<?php echo $satir['gorev_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu görevi silmek istediğinize emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz görev tanımlanmadı.</div>
    <?php endif; ?>
</div> </body> </html>