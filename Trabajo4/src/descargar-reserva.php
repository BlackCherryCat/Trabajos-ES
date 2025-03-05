<?php
require_once 'includes/funciones.php';
require_once 'includes/conexion.php';

if (isset($_GET['I']) && isset($_GET['id'])) {
    $reserva_id = $_GET['id'];
    descargarPDFR($db, $reserva_id);
}
elseif (isset($_GET['id'])) {
    $reserva_id = $_GET['id'];
    descargarPDFT($db, $reserva_id);
}


header('Location: mis-reservas.php');
exit();
