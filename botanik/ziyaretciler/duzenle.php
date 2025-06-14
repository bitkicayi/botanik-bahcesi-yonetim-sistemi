<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$ziyaretci_id = $_GET['id'] ?? null;
if (!$ziyaretci_id) {
    echo "Geçersiz ID";
    exit;
}
// Form gönderildiyse güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = trim($_POST["ad_soyad"]);
    $tarih = $_POST["ziyaret_tarihi"];
    $neden = trim($_POST["ziyaret_nedeni"]);
    $iletisim = trim($_POST["iletisim"]);
    $guncelle = $conn->prepare("UPDATE ziyaretciler SET ad_soyad = ?, ziyaret_tarihi = ?, ziyaret_nedeni = ?, iletisim = ? WHERE ziyaretci_id = ? AND ekleyen_kullanici_id = ?");
    $guncelle->bind_param("ssssii", $ad_soyad, $tarih, $neden, $iletisim, $ziyaretci_id, $kullanici_id);
    if ($guncelle->execute()) {
        header("Location: listele.php");
        exit;
    } else {
        $hata = "Güncelleme hatası: " . $conn->error;
    }
}
// Mevcut verileri çek
$sorgu = $conn->prepare("SELECT * FROM ziyaretciler WHERE ziyaretci_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $ziyaretci_id, $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
if ($sonuc->num_rows === 0) {
    echo "Kayıt bulunamadı.";
    exit;
}
$veri = $sonuc->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ziyaretçi Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Ziyaretçi Düzenle</h2>
    <?php if (!empty($hata)): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <input type="text" class="form-control" name="ad_soyad" value="<?php echo htmlspecialchars($veri["ad_soyad"]); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ziyaret Tarihi</label>
            <input type="date" class="form-control" name="ziyaret_tarihi" value="<?php echo $veri["ziyaret_tarihi"]; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ziyaret Nedeni</label>
            <textarea class="form-control" name="ziyaret_nedeni"><?php echo htmlspecialchars($veri["ziyaret_nedeni"]); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">İletişim</label>
            <input type="text" class="form-control" name="iletisim" value="<?php echo htmlspecialchars($veri["iletisim"]); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="listele.php" class="btn btn-secondary">İptal</a>
    </form>
</div> </body> </html>