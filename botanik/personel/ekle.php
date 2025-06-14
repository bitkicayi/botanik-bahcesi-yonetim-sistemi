<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = trim($_POST["ad_soyad"]);
    $unvan = trim($_POST["unvan"]);
    $telefon = trim($_POST["telefon"]);
    $email = trim($_POST["email"]);
    $aciklama = trim($_POST["aciklama"]);
    if (empty($ad_soyad)) {
        $hata = "Ad Soyad alanı zorunludur.";
    } else {
        $sorgu = $conn->prepare("INSERT INTO personel (ad_soyad, unvan, telefon, email, aciklama, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?, ?)");
        $sorgu->bind_param("sssssi", $ad_soyad, $unvan, $telefon, $email, $aciklama, $kullanici_id);

        if ($sorgu->execute()) {
            $basarili = "Personel başarıyla eklendi.";
        } else {
            $hata = "Veritabanı hatası: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Personel Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Yeni Personel Ekle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php elseif ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Ad Soyad *</label>
            <input type="text" class="form-control" name="ad_soyad" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ünvan</label>
            <input type="text" class="form-control" name="unvan">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" class="form-control" name="telefon">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="aciklama" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>