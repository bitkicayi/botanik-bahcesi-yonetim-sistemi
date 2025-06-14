<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$etkinlik_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sorgu = $conn->prepare("SELECT * FROM etkinlikler WHERE etkinlik_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $etkinlik_id, $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows != 1) {
    echo "Etkinlik bulunamadı veya yetkiniz yok.";
    exit;
}
$etkinlik = $sonuc->fetch_assoc();
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = trim($_POST["etkinlik_ad"]);
    $tarih = $_POST["etkinlik_tarih"];
    $yeri = trim($_POST["etkinlik_yeri"]);
    $aciklama = trim($_POST["etkinlik_aciklama"]);
    $guncelle = $conn->prepare("UPDATE etkinlikler SET etkinlik_ad=?, etkinlik_tarih=?, etkinlik_yeri=?, etkinlik_aciklama=? WHERE etkinlik_id=? AND ekleyen_kullanici_id=?");
    $guncelle->bind_param("ssssii", $ad, $tarih, $yeri, $aciklama, $etkinlik_id, $kullanici_id);
    if ($guncelle->execute()) {
        $basarili = "Etkinlik başarıyla güncellendi!";
        $etkinlik["etkinlik_ad"] = $ad;
        $etkinlik["etkinlik_tarih"] = $tarih;
        $etkinlik["etkinlik_yeri"] = $yeri;
        $etkinlik["etkinlik_aciklama"] = $aciklama;
    } else {
        $hata = "Güncelleme sırasında bir hata oluştu.";
    }
    $guncelle->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Etkinlik Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Etkinliği Güncelle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Etkinlik Adı</label>
            <input type="text" class="form-control" name="etkinlik_ad" required value="<?php echo htmlspecialchars($etkinlik["etkinlik_ad"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" class="form-control" name="etkinlik_tarih" value="<?php echo $etkinlik["etkinlik_tarih"]; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Yer</label>
            <input type="text" class="form-control" name="etkinlik_yeri" value="<?php echo htmlspecialchars($etkinlik["etkinlik_yeri"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="etkinlik_aciklama" rows="3"><?php echo htmlspecialchars($etkinlik["etkinlik_aciklama"]); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="listele.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>