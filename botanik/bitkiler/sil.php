<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$bitki_id = $_GET['id'] ?? null;
if (!$bitki_id) {
    echo "<h3 style='color:red;'> Geçersiz bitki ID.</h3>";
    exit;
}
// Önce bu bitkiye bağlı bakım planlarını sil
$sorgu1 = $conn->prepare("DELETE FROM bakim_planlari WHERE bitki_id = ?");
$sorgu1->bind_param("i", $bitki_id);
$sorgu1->execute();
// Ardından bitkiyi sil
$sorgu2 = $conn->prepare("DELETE FROM bitkiler WHERE bitki_id = ? AND ekleyen_kullanici_id = ?");
$sorgu2->bind_param("ii", $bitki_id, $kullanici_id);
if ($sorgu2->execute()) {
    header("Location: listele.php?durum=silindi");
    exit;
} else {
    echo "<h3 style='color:red;'> Bitki silinemedi.</h3>";
    echo "<p>Teknik bir hata oluştu. Lütfen daha sonra tekrar deneyin.</p>";
    echo "<a href='listele.php'>← Geri dön</a>";
}
?>
