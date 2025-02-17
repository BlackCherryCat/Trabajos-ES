<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['profesor'])) {
    header("Location: login.php");
}

?>