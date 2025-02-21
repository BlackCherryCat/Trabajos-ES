<?php
require_once 'conexion.php';
//require_once 'redireccion.php';
require_once 'funciones.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/calendar.css">
    <!-- Hace falta hacer una funcion que saque el nombre del titulo -->
    <title>Reservas-Aula</title>
</head>
<body>
    <div>
        <!-- Header -->
    <header class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <button class="navbar-toggler d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand fw-bold fs-4" href="./reserva.php">Reserva-Aula</a>
            <div class="dropdown ms-auto">
                <a href="#" class="d-block text-decoration-none <!--dropdown-toggle-->" data-bs-toggle="dropdown">
                    <img src="<?= $_SESSION['profesor']['ImgPerfilURL'] ?>" alt="Perfil" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="mi-perfil.php">Mi perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./acciones/logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Barra lateral fija para pantallas grandes -->
    <div class="sidebar-lg d-none d-lg-flex flex-column">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item"><a class="nav-link" href="./reserva.php">Reserva</a></li>
            <li class="nav-item"><a class="nav-link" href="./mis-reservas.php">Mis Reservas</a></li>
            <li class="nav-item"><a class="nav-link" href="./profesores.php">Profesores</a></li>
        </ul>
        <div class="sidebar-footer">
            © 2025 Reserva-Aula. Todos los derechos reservados.
        </div>
    </div>
    
    

    <!-- Offcanvas para pantallas pequeñas -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <h5 id="sidebarLabel" class="offcanvas-title fw-bold fs-4">Reserva-Aula</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <ul class="nav flex-column mb-auto">
                <li class="nav-item"><a class="nav-link active" href="./reserva.php">Reserva</a></li>
                <li class="nav-item"><a class="nav-link" href="./mis-reservas.php">Mis Reservas</a></li>
                <li class="nav-item"><a class="nav-link" href="./profesores.php">Profesores</a></li>
            </ul>
            <div class="mt-auto text-center text-body-secondary">
                © 2024 Seguros Axarquia. Todos los derechos reservados.
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container mt-5 pt-4 content-lg">