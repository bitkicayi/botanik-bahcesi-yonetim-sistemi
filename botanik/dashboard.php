<?php
session_start();
// Giriş yapılmamışsa login sayfasına yönlendir
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kontrol Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Hoş geldin, <?php echo $_SESSION["kullanici_ad"] . " " . $_SESSION["kullanici_soyad"]; ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
    </div>
    <div class="list-group">
        <h5 class="mb-2">🌿 Bitkiler</h5>
        <a href="bitkiler/ekle.php" class="list-group-item list-group-item-action">➕ Bitki Ekle</a>
        <a href="bitkiler/listele.php" class="list-group-item list-group-item-action">📋 Bitkileri Listele</a>
        <h5 class="mt-4 mb-2">🖼️ Sergiler</h5>
        <a href="sergiler/ekle.php" class="list-group-item list-group-item-action">➕ Sergi Ekle</a>
        <a href="sergiler/listele.php" class="list-group-item list-group-item-action">📋 Sergileri Listele</a>
        <h5 class="mt-4 mb-2">🎫 Etkinlikler</h5>
        <a href="etkinlikler/ekle.php" class="list-group-item list-group-item-action">➕ Etkinlik Ekle</a>
        <a href="etkinlikler/listele.php" class="list-group-item list-group-item-action">📋 Etkinlikleri Listele</a>
        <h5 class="mt-4 mb-2">👥 Ziyaretçiler</h5>
        <a href="ziyaretciler/ekle.php" class="list-group-item list-group-item-action">➕ Ziyaretçi Ekle</a>
        <a href="ziyaretciler/listele.php" class="list-group-item list-group-item-action">📋 Ziyaretçileri Listele</a>
        <h5 class="mt-4 mb-2">🛠️ Bakım Planları</h5>
        <a href="bakim/ekle.php" class="list-group-item list-group-item-action">➕ Bakım Planı Ekle</a>
        <a href="bakim/listele.php" class="list-group-item list-group-item-action">📋 Planları Listele</a>
        <h5 class="mt-4 mb-2">👩‍🌾 Personel Yönetimi</h5>
        <a href="personel/ekle.php" class="list-group-item list-group-item-action">➕ Personel Ekle</a>
        <a href="personel/listele.php" class="list-group-item list-group-item-action">📋 Personel Listesi</a>
    </div>
</div> </body> </html>