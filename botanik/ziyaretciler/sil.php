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
    echo "Geçersiz ID.";
    exit;
}
$sil = $conn->prepare("DELETE FROM ziyaretciler WHERE ziyaretci_id = ? AND ekleyen_kullanici_id = ?");
$sil->bind_param("ii", $ziyaretci_id, $kullanici_id);
if ($sil->execute()) {
    header("Location: listele.php");
    exit;
} else {
    echo "Silme işlemi başarısız: " . $conn->error;
}
?>