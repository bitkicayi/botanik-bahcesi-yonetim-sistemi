<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
if (isset($_GET["id"])) {
    $etkinlik_id = intval($_GET["id"]);
    $kullanici_id = $_SESSION["kullanici_id"];
    $sil = $conn->prepare("DELETE FROM etkinlikler WHERE etkinlik_id = ? AND ekleyen_kullanici_id = ?");
    $sil->bind_param("ii", $etkinlik_id, $kullanici_id);

    if ($sil->execute()) {
        header("Location: listele.php");
        exit;
    } else {
        echo "Silme işlemi başarısız.";
    }
    $sil->close();
} else {
    echo "Geçersiz istek.";
}
?>