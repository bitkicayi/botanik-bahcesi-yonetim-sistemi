<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$personel_id = $_GET['id'] ?? null;
if (!$personel_id) {
    echo "<h3 style='color:red;'> Geçersiz personel ID.</h3>";
    exit;
}
// Önce bu personele bağlı görevleri sil
$sorgu1 = $conn->prepare("DELETE FROM gorevler WHERE personel_id = ?");
$sorgu1->bind_param("i", $personel_id);
$sorgu1->execute();
$sorgu2 = $conn->prepare("DELETE FROM personel WHERE personel_id = ? AND ekleyen_kullanici_id = ?");
$sorgu2->bind_param("ii", $personel_id, $kullanici_id);
if ($sorgu2->execute()) {
    header("Location: listele.php?durum=silindi");
    exit;
} else {
    echo "<h3 style='color:red;'> Personel silinemedi.</h3>";
    echo "<p>Bu personele ait görevler olabilir veya teknik bir sorun oluştu.</p>";
    echo "<a href='listele.php'>← Geri dön</a>";
}
?>
