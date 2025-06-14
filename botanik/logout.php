<?php
session_start();
session_unset(); // Tüm oturum verilerini temizle
session_destroy(); // Oturumu tamamen yok et
header("Location: login.php");
exit;
?>