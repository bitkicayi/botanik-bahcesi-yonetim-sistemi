<?php
session_start();
require_once 'includes/db.php';
$hata = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen veriler
    $ad = trim($_POST["ad"]);
    $soyad = trim($_POST["soyad"]);
    $email = trim($_POST["email"]);
    $sifre = $_POST["sifre"];
    // E-posta zaten kayıtlı mı?
    $kontrol = $conn->prepare("SELECT kullanici_id FROM kullanicilar WHERE kullanici_email = ?");
    $kontrol->bind_param("s", $email);
    $kontrol->execute();
    $kontrol->store_result();
    if ($kontrol->num_rows > 0) {
        $hata = "Bu e-posta adresi zaten kayıtlı.";
    } else {
        // Şifreyi hash'le
        $hashliSifre = password_hash($sifre, PASSWORD_DEFAULT);
        // Veritabanına ekle
        $ekle = $conn->prepare("INSERT INTO kullanicilar (kullanici_ad, kullanici_soyad, kullanici_email, kullanici_sifre) VALUES (?, ?, ?, ?)");
        $ekle->bind_param("ssss", $ad, $soyad, $email, $hashliSifre);

        if ($ekle->execute()) {
            $basarili = "Kayıt başarılı! Giriş yapabilirsiniz.";
        } else {
            $hata = "Kayıt sırasında bir hata oluştu.";
        }
        $ekle->close();
    }
    $kontrol->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Kayıt Ol</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <?php if ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="ad" class="form-label">Ad</label>
            <input type="text" class="form-control" name="ad" required>
        </div>
        <div class="mb-3">
            <label for="soyad" class="form-label">Soyad</label>
            <input type="text" class="form-control" name="soyad" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="sifre" class="form-label">Şifre</label>
            <input type="password" class="form-control" name="sifre" required>
        </div>
        <button type="submit" class="btn btn-primary">Kayıt Ol</button>
    </form>
    <p class="mt-3">Zaten hesabın var mı? <a href="login.php">Giriş Yap</a></p>
</div> </body> </html>