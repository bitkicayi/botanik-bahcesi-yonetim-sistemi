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
    echo "Geçersiz ID.";
    exit;
}
$sorgu = $conn->prepare("DELETE FROM personel WHERE personel_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $personel_id, $kullanici_id);
if ($sorgu->execute()) {
    header("Location: listele.php");
    exit;
} else {
    echo "Silme işlemi başarısız: " . $conn->error;
}
?>