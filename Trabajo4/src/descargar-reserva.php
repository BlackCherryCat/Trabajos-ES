<?php
require_once 'includes/funciones.php';
require_once 'includes/conexion.php';

if (isset($_GET['id']) && isset($_GET['op'])) {
    $reserva_id = $_GET['id'];
    $op = $_GET['op'];
    descargarPDF($op, $db, $reserva_id);
}


header('Location: mis-reservas.php');
exit();
