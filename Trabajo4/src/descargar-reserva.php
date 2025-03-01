<?php
require_once 'includes/funciones.php';
require_once 'includes/conexion.php';

if (isset($_GET['id'])) {
    $reserva_id = $_GET['id'];
    descargarPDF($db, $reserva_id);
}

header('Location: mis-reservas.php');
exit();
