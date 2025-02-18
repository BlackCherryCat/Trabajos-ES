<?php
require_once '../includes/redireccion.php';
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

// Comprueba si la solicitud HTTP es de tipo POST, lo que indica que el formulario fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    if (empty($nombre)) {
        $_SESSION['error_general'] = "El nombre no puede estar vacío.";
        header("Location: ../crear-profesor.php");
        exit();
    }
    
    $apellidos = htmlspecialchars(trim($_POST['apellidos']), ENT_QUOTES, 'UTF-8');
    if (empty($apellidos)) {
        $_SESSION['error_general'] = "Los apellidos no pueden estar vacíos.";
        header("Location: ../crear-profesor.php");
        exit();
    }
    
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['error_general'] = "El email no es válido.";
        header("Location: ../crear-profesor.php");
        exit();
    }
    
    $passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
    $esAdmin = isset($_POST['esAdmin']) ? intval($_POST['esAdmin']) : 0;
    $esAlta = isset($_POST['esAlta']) ? intval($_POST['esAlta']) : 1;
    
    // Manejo de la imagen
    $imgPerfilURL = "";
    if (isset($_FILES['imgPerfil']) && $_FILES['imgPerfil']['error'] === UPLOAD_ERR_OK) {
        if (subirImagen($_FILES['imgPerfil'])) {
            $imgPerfilURL = "../assets/img/perfiles/" . basename($_FILES['imgPerfil']['name']);
        } else {
            $_SESSION['error_general'] = "Error al subir la imagen.";
            header("Location: ../crear-profesor.php");
            exit();
        }
    }
    
    // Llamar a la función para crear el profesor
    crearProfesor($db, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL);
    
    // Redirige al usuario a la lista de profesores después de completar la operación.
    header("Location: ../profesores.php");
    exit();
}