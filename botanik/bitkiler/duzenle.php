<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$bitki_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Bitki bilgilerini çek
$sorgu = $conn->prepare("SELECT * FROM bitkiler WHERE bitki_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $bitki_id, $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows != 1) {
    echo "Kayıt bulunamadı veya yetkiniz yok.";
    exit;
}
$bitki = $sonuc->fetch_assoc();
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bitki_ad = trim($_POST["bitki_ad"]);
    $bitki_tur = trim($_POST["bitki_tur"]);
    $bitki_dikim_tarihi = $_POST["bitki_dikim_tarihi"];
    $bitki_sulama_sikligi = trim($_POST["bitki_sulama_sikligi"]);
    $bitki_aciklama = trim($_POST["bitki_aciklama"]);
    $guncelle = $conn->prepare("UPDATE bitkiler SET bitki_ad=?, bitki_tur=?, bitki_dikim_tarihi=?, bitki_sulama_sikligi=?, bitki_aciklama=? WHERE bitki_id=? AND ekleyen_kullanici_id=?");
    $guncelle->bind_param("ssssssi", $bitki_ad, $bitki_tur, $bitki_dikim_tarihi, $bitki_sulama_sikligi, $bitki_aciklama, $bitki_id, $kullanici_id);
    if ($guncelle->execute()) {
        $basarili = "Kayıt başarıyla güncellendi!";
        // Verileri yenile
        $bitki["bitki_ad"] = $bitki_ad;
        $bitki["bitki_tur"] = $bitki_tur;
        $bitki["bitki_dikim_tarihi"] = $bitki_dikim_tarihi;
        $bitki["bitki_sulama_sikligi"] = $bitki_sulama_sikligi;
        $bitki["bitki_aciklama"] = $bitki_aciklama;
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
    <title>Bitki Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bitki Bilgilerini Güncelle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Bitki Adı</label>
            <input type="text" class="form-control" name="bitki_ad" required value="<?php echo htmlspecialchars($bitki["bitki_ad"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Bitki Türü</label>
            <input type="text" class="form-control" name="bitki_tur" value="<?php echo htmlspecialchars($bitki["bitki_tur"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Dikim Tarihi</label>
            <input type="date" class="form-control" name="bitki_dikim_tarihi" value="<?php echo $bitki["bitki_dikim_tarihi"]; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Sulama Sıklığı</label>
            <input type="text" class="form-control" name="bitki_sulama_sikligi" value="<?php echo htmlspecialchars($bitki["bitki_sulama_sikligi"]); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="bitki_aciklama" rows="3"><?php echo htmlspecialchars($bitki["bitki_aciklama"]); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="listele.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>