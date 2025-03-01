<?php
require_once '../includes/redireccion.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: reserva.php");
}
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

if (isset($_SESSION['profesor']) && isset($_GET['id'])) {
    $idProfesor = (int)$_GET['id'];
    $profesor = obtenerProfesor($db, $idProfesor);
    
    if($profesor['ImgPerfilURL'] != './assets/img/perfiles/usuario.avif'){
        borrarImagen($profesor['ImgPerfilURL']);
    }
    borrarProfesor($db, $idProfesor);
}

header("Location: ../profesores.php");