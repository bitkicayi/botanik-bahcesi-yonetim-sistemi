<?php
session_start();
require_once '../includes/db.php';
// Oturum kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bitki_ad = trim($_POST["bitki_ad"]);
    $bitki_tur = trim($_POST["bitki_tur"]);
    $bitki_dikim_tarihi = $_POST["bitki_dikim_tarihi"];
    $bitki_sulama_sikligi = trim($_POST["bitki_sulama_sikligi"]);
    $bitki_aciklama = trim($_POST["bitki_aciklama"]);
    $ekleyen_id = $_SESSION["kullanici_id"];
    $ekle = $conn->prepare("INSERT INTO bitkiler (bitki_ad, bitki_tur, bitki_dikim_tarihi, bitki_sulama_sikligi, bitki_aciklama, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?, ?)");
    $ekle->bind_param("sssssi", $bitki_ad, $bitki_tur, $bitki_dikim_tarihi, $bitki_sulama_sikligi, $bitki_aciklama, $ekleyen_id);
    if ($ekle->execute()) {
        $basarili = "Bitki başarıyla eklendi!";
    } else {
        $hata = "Hata oluştu: " . $conn->error;
    }
    $ekle->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bitki Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bitki Ekle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Bitki Adı</label>
            <input type="text" class="form-control" name="bitki_ad" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bitki Türü</label>
            <input type="text" class="form-control" name="bitki_tur">
        </div>
        <div class="mb-3">
            <label class="form-label">Dikim Tarihi</label>
            <input type="date" class="form-control" name="bitki_dikim_tarihi">
        </div>
        <div class="mb-3">
            <label class="form-label">Sulama Sıklığı</label>
            <input type="text" class="form-control" name="bitki_sulama_sikligi">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="bitki_aciklama" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Bitkiyi Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>