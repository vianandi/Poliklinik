<?php
session_start();
if (isset($_SESSION['username'])) {
    // Hapus session
    unset($_SESSION['username']);
}

header("Location: index.php");
exit();
?>