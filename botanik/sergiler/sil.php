<?php
session_start();
require_once '../includes/db.php';
// Giriş kontrolü
if (!isset($_SESSION["kullanici_id"])) {
    header("Location: ../login.php");
    exit;
}
// Geçerli sergi ID var mı?
if (isset($_GET["id"])) {
    $sergi_id = intval($_GET["id"]);
    $kullanici_id = $_SESSION["kullanici_id"];
    $sil = $conn->prepare("DELETE FROM sergiler WHERE sergi_id = ? AND ekleyen_kullanici_id = ?");
    $sil->bind_param("ii", $sergi_id, $kullanici_id);
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