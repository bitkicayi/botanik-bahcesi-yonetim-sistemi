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
    echo "Geçersiz ID.";
    exit;
}
// Kullanıcının kendi planını silebilmesi için
$sorgu = $conn->prepare("DELETE FROM bakim_planlari WHERE plan_id = ? AND ekleyen_kullanici_id = ?");
$sorgu->bind_param("ii", $plan_id, $kullanici_id);

if ($sorgu->execute()) {
    header("Location: listele.php");
    exit;
} else {
    echo "Silme işlemi başarısız: " . $conn->error;
}
?>