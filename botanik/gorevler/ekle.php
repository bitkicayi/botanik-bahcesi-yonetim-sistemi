<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$hata = $basarili = "";
// Bitki ve sergi verilerini çek
$bitkiler = $conn->query("SELECT bitki_id, bitki_ad FROM bitkiler WHERE ekleyen_kullanici_id = $kullanici_id");
$sergiler = $conn->query("SELECT sergi_id, sergi_ad FROM sergiler WHERE ekleyen_kullanici_id = $kullanici_id");
$personeller = $conn->query("SELECT personel_id, ad_soyad FROM personel WHERE ekleyen_kullanici_id = $kullanici_id");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gorev_ad = trim($_POST["gorev_ad"]);
    $gorev_tipi = $_POST["gorev_tipi"];
    $hedef_id = (int) $_POST["hedef_id"];
    $personel_id = (int) $_POST["personel_id"];
    $gorev_tarih = $_POST["gorev_tarih"];
    $aciklama = trim($_POST["aciklama"]);
    if (empty($gorev_ad) || empty($gorev_tipi) || empty($hedef_id) || empty($personel_id) || empty($gorev_tarih)) {
        $hata = "Tüm zorunlu alanları doldurmalısınız.";
    } else {
        $sorgu = $conn->prepare("INSERT INTO gorevler (gorev_ad, gorev_tipi, hedef_id, personel_id, gorev_tarih, aciklama, ekleyen_kullanici_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sorgu->bind_param("ssiissi", $gorev_ad, $gorev_tipi, $hedef_id, $personel_id, $gorev_tarih, $aciklama, $kullanici_id);

        if ($sorgu->execute()) {
            $basarili = "Görev başarıyla eklendi.";
        } else {
            $hata = "Veritabanı hatası: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Görev Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
    function guncelleHedefListesi() {
        var tip = document.getElementById('gorev_tipi').value;
        document.getElementById('bitki_sec').style.display = (tip === 'Bitki') ? 'block' : 'none';
        document.getElementById('sergi_sec').style.display = (tip === 'Sergi') ? 'block' : 'none';
    }
    </script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Yeni Görev Ekle</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo $hata; ?></div>
    <?php elseif ($basarili): ?>
        <div class="alert alert-success"><?php echo $basarili; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Görev Adı *</label>
            <input type="text" name="gorev_ad" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Görev Tipi *</label>
            <select name="gorev_tipi" id="gorev_tipi" class="form-select" onchange="guncelleHedefListesi()" required>
                <option value="">Seçiniz</option>
                <option value="Bitki">Bitki</option>
                <option value="Sergi">Sergi</option>
            </select>
        </div>
        <div class="mb-3" id="bitki_sec" style="display:none;">
            <label class="form-label">Hedef Bitki *</label>
            <select name="hedef_id" class="form-select">
                <?php while ($b = $bitkiler->fetch_assoc()): ?>
                    <option value="<?php echo $b['bitki_id']; ?>"><?php echo htmlspecialchars($b['bitki_ad']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3" id="sergi_sec" style="display:none;">
            <label class="form-label">Hedef Sergi *</label>
            <select name="hedef_id" class="form-select">
                <?php while ($s = $sergiler->fetch_assoc()): ?>
                    <option value="<?php echo $s['sergi_id']; ?>"><?php echo htmlspecialchars($s['sergi_ad']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Sorumlu Personel *</label>
            <select name="personel_id" class="form-select" required>
                <?php while ($p = $personeller->fetch_assoc()): ?>
                    <option value="<?php echo $p['personel_id']; ?>"><?php echo htmlspecialchars($p['ad_soyad']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Görev Tarihi *</label>
            <input type="date" name="gorev_tarih" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea name="aciklama" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="../dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div> </body> </html>