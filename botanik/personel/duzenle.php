<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$personel_id = $_GET['id'] ?? null;
if (!$personel_id) {
    echo "Geçersiz personel ID.";
    exit;
}
// Form gönderildiyse güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = trim($_POST["ad_soyad"]);
    $unvan = trim($_POST["unvan"]);
    $telefon = trim($_POST["telefon"]);
    $email = trim($_POST["email"]);
    $aciklama = trim($_POST["aciklama"]);
    $guncelle = $conn->prepare("UPDATE personel SET ad_soyad = ?, unvan = ?, telefon = ?, email = ?, aciklama = ? WHERE personel_id = ? AND ekleyen_kullanici_id = ?");
    $guncelle->bind_param("sssssii", $ad_soyad, $unvan, $telefon, $email, $aciklama, $personel_id, $kullanici_id);
    if ($guncelle->execute()) {
        header("Location: listele.php");
        exit;
    } else {
        $hata = "Güncelleme başarısız: " . $conn->error;
    }
}
// Mevcut personel verisi çek
$sorgu = $conn->prepare("SELECT * FROM personel WHERE personel_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $personel_id, $kullanici_id);
$sorgu->execute();
$sonuc = $sorgu->get_result();
$personel = $sonuc->fetch_assoc();
if (!$personel) {
    echo "Kayıt bulunamadı.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Personel Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Personel Bilgilerini Düzenle</h2>
    <?php if (!empty($hata)): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Ad Soyad *</label>
            <input type="text" class="form-control" name="ad_soyad" value="<?php echo htmlspecialchars($personel['ad_soyad']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ünvan</label>
            <input type="text" class="form-control" name="unvan" value="<?php echo htmlspecialchars($personel['unvan']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" class="form-control" name="telefon" value="<?php echo htmlspecialchars($personel['telefon']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($personel['email']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="aciklama"><?php echo htmlspecialchars($personel['aciklama']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="listele.php" class="btn btn-secondary">İptal</a>
    </form>
</div> </body> </html>