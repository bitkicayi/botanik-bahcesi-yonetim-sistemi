<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
// ID kontrolü
if (isset($_GET["id"])) {
    $bitki_id = intval($_GET["id"]);
    $kullanici_id = $_SESSION["kullanici_id"];
    // Sadece bu kullanıcıya ait olan bitkiler silinebilmesi için
    $sil = $conn->prepare("DELETE FROM bitkiler WHERE bitki_id = ? AND ekleyen_kullanici_id = ?");
    $sil->bind_param("ii", $bitki_id, $kullanici_id);
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