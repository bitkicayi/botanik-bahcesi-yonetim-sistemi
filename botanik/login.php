<?php
session_start();
require_once 'includes/db.php';
$hata = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $sifre = $_POST["sifre"];
    // E-posta ile kullanıcıyı bul
    $sorgu = $conn->prepare("SELECT kullanici_id, kullanici_ad, kullanici_soyad, kullanici_sifre FROM kullanicilar WHERE kullanici_email = ?");
    $sorgu->bind_param("s", $email);
    $sorgu->execute();
    $sorgu->store_result();
    if ($sorgu->num_rows == 1) {
        $sorgu->bind_result($id, $ad, $soyad, $hashliSifre);
        $sorgu->fetch();

        if (password_verify($sifre, $hashliSifre)) {
            // Giriş başarılı → oturum oluştur
            $_SESSION["kullanici_id"] = $id;
            $_SESSION["kullanici_ad"] = $ad;
            $_SESSION["kullanici_soyad"] = $soyad;
            header("Location: dashboard.php");
            exit;
        } else {
            $hata = "Şifre hatalı.";
        }
    } else {
        $hata = "Böyle bir kullanıcı bulunamadı.";
    }

    $sorgu->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Giriş Yap</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="sifre" class="form-label">Şifre</label>
            <input type="password" class="form-control" name="sifre" required>
        </div>
        <button type="submit" class="btn btn-primary">Giriş Yap</button>
    </form>
    <p class="mt-3">Hesabın yok mu? <a href="register.php">Kayıt Ol</a></p>
</div> </body> </html>