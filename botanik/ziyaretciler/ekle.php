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
    $ad_soyad = trim($_POST["ad_soyad"]);
    $tarih = $_POST["ziyaret_tarihi"];
    $neden = trim($_POST["ziyaret_nedeni"]);
    $iletisim = trim($_POST["iletisim"]);
    $ekleyen_id = $_SESSION["kullanici_id"];
    $sorgu = $conn->prepare("INSERT INTO ziyaretciler (ad_soyad, ziyaret_tarihi, ziyaret_nedeni, iletisim, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?)");
    $sorgu->bind_param("ssssi", $ad_soyad, $tarih, $neden, $iletisim, $ekleyen_id);
    if ($sorgu->execute()) {
        $basarili = "Ziyaretçi başarıyla kaydedildi!";
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
    <title>Ziyaretçi Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Yeni Ziyaretçi Kaydı</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <input type="text" class="form-control" name="ad_soyad" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ziyaret Tarihi</label>
            <input type="date" class="form-control" name="ziyaret_tarihi" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ziyaret Nedeni</label>
            <textarea class="form-control" name="ziyaret_nedeni" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">İletişim Bilgisi (İsteğe Bağlı)</label>
            <input type="text" class="form-control" name="iletisim">
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>