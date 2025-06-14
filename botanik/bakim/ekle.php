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
// Kullanıcının bitkilerini çek
$bitkiSorgu = $conn->prepare("SELECT bitki_id, bitki_ad FROM bitkiler WHERE ekleyen_kullanici_id = ?");
$bitkiSorgu->bind_param("i", $kullanici_id);
$bitkiSorgu->execute();
$bitkiler = $bitkiSorgu->get_result();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bitki_id = $_POST["bitki_id"];
    $islem_turu = $_POST["islem_turu"];
    $plan_tarihi = $_POST["plan_tarihi"];
    $aciklama = trim($_POST["aciklama"]);
    $sorgu = $conn->prepare("INSERT INTO bakim_planlari (bitki_id, islem_turu, plan_tarihi, aciklama, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?)");
    $sorgu->bind_param("isssi", $bitki_id, $islem_turu, $plan_tarihi, $aciklama, $kullanici_id);
    if ($sorgu->execute()) {
        $basarili = "Bakım planı başarıyla eklendi.";
    } else {
        $hata = "Hata oluştu: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakım Planı Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Yeni Bitki Bakım Planı</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php elseif ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Bitki Seç</label>
            <select class="form-select" name="bitki_id" required>
                <option value="">-- Bitki Seçin --</option>
                <?php while ($bitki = $bitkiler->fetch_assoc()): ?>
                    <option value="<?php echo $bitki["bitki_id"]; ?>">
                        <?php echo htmlspecialchars($bitki["bitki_ad"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">İşlem Türü</label>
            <select class="form-select" name="islem_turu" required>
                <option value="Sulama">Sulama</option>
                <option value="Gübreleme">Gübreleme</option>
                <option value="Budama">Budama</option>
                <option value="Diğer">Diğer</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Planlanan Tarih</label>
            <input type="date" class="form-control" name="plan_tarihi" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="aciklama" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>