<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$gorev_id = $_GET["id"] ?? null;

if (!$gorev_id) {
    echo "Geçersiz görev ID'si.";
    exit;
}
$sorgu = $conn->prepare("DELETE FROM gorevler WHERE gorev_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $gorev_id, $kullanici_id);
if ($sorgu->execute()) {
    header("Location: listele.php?silme=ok");
    exit;
} else {
    echo "Görev silinemedi: " . $conn->error;
}
?>