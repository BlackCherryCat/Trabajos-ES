<?php
session_start();

if (isset($_SESSION['profesor'])) {
    session_destroy();
}

header("Location: ../login.php");

?>