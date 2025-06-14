<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$sergi_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Sergi verisini çek
$sorgu = $conn->prepare("SELECT * FROM sergiler WHERE sergi_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $sergi_id, $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows != 1) {
    echo "Sergi bulunamadı veya yetkiniz yok.";
    exit;
}
$sergi = $sonuc->fetch_assoc();
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = trim($_POST["sergi_ad"]);
    $tarih = $_POST["sergi_tarih"];
    $yeri = trim($_POST["sergi_yeri"]);
    $aciklama = trim($_POST["sergi_aciklama"]);

    $guncelle = $conn->prepare("UPDATE sergiler SET sergi_ad=?, sergi_tarih=?, sergi_yeri=?, sergi_aciklama=? WHERE sergi_id=? AND ekleyen_kullanici_id=?");
    $guncelle->bind_param("ssssii", $ad, $tarih, $yeri, $aciklama, $sergi_id, $kullanici_id);

    if ($guncelle->execute()) {
        $basarili = "Sergi başarıyla güncellendi!";
        // Değerleri formda güncelle
        $sergi["sergi_ad"] = $ad;
        $sergi["sergi_tarih"] = $tarih;
        $sergi["sergi_yeri"] = $yeri;
        $sergi["sergi_aciklama"] = $aciklama;
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
    <title>Sergi Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Sergiyi Güncelle</h2>

    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>

    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Sergi Adı</label>
            <input type="text" class="form-control" name="sergi_ad" required value="<?php echo htmlspecialchars($sergi["sergi_ad"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" class="form-control" name="sergi_tarih" value="<?php echo $sergi["sergi_tarih"]; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Yer</label>
            <input type="text" class="form-control" name="sergi_yeri" value="<?php echo htmlspecialchars($sergi["sergi_yeri"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="sergi_aciklama" rows="3"><?php echo htmlspecialchars($sergi["sergi_aciklama"]); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="listele.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>