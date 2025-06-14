<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = trim($_POST["sergi_ad"]);
    $tarih = $_POST["sergi_tarih"];
    $yeri = trim($_POST["sergi_yeri"]);
    $aciklama = trim($_POST["sergi_aciklama"]);
    $ekleyen_id = $_SESSION["kullanici_id"];
    $sorgu = $conn->prepare("INSERT INTO sergiler (sergi_ad, sergi_tarih, sergi_yeri, sergi_aciklama, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?)");
    $sorgu->bind_param("ssssi", $ad, $tarih, $yeri, $aciklama, $ekleyen_id);
    if ($sorgu->execute()) {
        $basarili = "Sergi başarıyla eklendi!";
    } else {
        $hata = "Hata oluştu: " . $conn->error;
    }
    $sorgu->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sergi Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Yeni Sergi Ekle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Sergi Adı</label>
            <input type="text" class="form-control" name="sergi_ad" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" class="form-control" name="sergi_tarih">
        </div>
        <div class="mb-3">
            <label class="form-label">Yer</label>
            <input type="text" class="form-control" name="sergi_yeri">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="sergi_aciklama" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>