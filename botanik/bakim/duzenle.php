<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$plan_id = $_GET['id'] ?? null;

if (!$plan_id) {
    echo "Geçersiz plan ID.";
    exit;
}
// Kullanıcının bitkilerini çek
$bitkiSorgu = $conn->prepare("SELECT bitki_id, bitki_ad FROM bitkiler WHERE ekleyen_kullanici_id = ?");
$bitkiSorgu->bind_param("i", $kullanici_id);
$bitkiSorgu->execute();
$bitkiler = $bitkiSorgu->get_result();
// Form gönderildiyse güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bitki_id = $_POST["bitki_id"];
    $islem_turu = $_POST["islem_turu"];
    $plan_tarihi = $_POST["plan_tarihi"];
    $aciklama = trim($_POST["aciklama"]);
    $guncelle = $conn->prepare("UPDATE bakim_planlari SET bitki_id = ?, islem_turu = ?, plan_tarihi = ?, aciklama = ? WHERE plan_id = ? AND ekleyen_kullanici_id = ?");
    $guncelle->bind_param("isssii", $bitki_id, $islem_turu, $plan_tarihi, $aciklama, $plan_id, $kullanici_id);
    if ($guncelle->execute()) {
        header("Location: listele.php");
        exit;
    } else {
        $hata = "Güncelleme başarısız: " . $conn->error;
    }
}
// Mevcut planı çek
$planSorgu = $conn->prepare("SELECT * FROM bakim_planlari WHERE plan_id = ? AND ekleyen_kullanici_id = ?");
$planSorgu->bind_param("ii", $plan_id, $kullanici_id);
$planSorgu->execute();
$plan = $planSorgu->get_result()->fetch_assoc();
if (!$plan) {
    echo "Plan bulunamadı.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakım Planı Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bakım Planı Düzenle</h2>
    <?php if (!empty($hata)): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Bitki</label>
            <select class="form-select" name="bitki_id" required>
                <?php while ($bitki = $bitkiler->fetch_assoc()): ?>
                    <option value="<?php echo $bitki["bitki_id"]; ?>" <?php echo $plan["bitki_id"] == $bitki["bitki_id"] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($bitki["bitki_ad"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">İşlem Türü</label>
            <select class="form-select" name="islem_turu" required>
                <?php
                $islemler = ["Sulama", "Gübreleme", "Budama", "Diğer"];
                foreach ($islemler as $tur) {
                    $secili = $plan["islem_turu"] == $tur ? "selected" : "";
                    echo "<option value='$tur' $secili>$tur</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Plan Tarihi</label>
            <input type="date" class="form-control" name="plan_tarihi" value="<?php echo $plan["plan_tarihi"]; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea class="form-control" name="aciklama"><?php echo htmlspecialchars($plan["aciklama"]); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="listele.php" class="btn btn-secondary">İptal</a>
    </form>
</div> </body> </html>