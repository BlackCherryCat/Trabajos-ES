<?php
require_once '../includes/redireccion.php';
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: reserva.php");
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
    $esAdmin = 0;
    $esAlta = isset($_POST['esAlta']) ? intval($_POST['esAlta']) : 1;
    
    // Manejo de la imagen
    $imgPerfilURL = "";
    if (isset($_FILES['imgPerfil']) && $_FILES['imgPerfil']['error'] !== 4) { // 4 = No se subió ningún archivo
        $imagen = subirImagen($_FILES['imgPerfil']);
        if ($imagen) {
            $imgPerfilURL = "./assets/img/perfiles/" . $imagen;

            //borrar foto anterior
            $profesor = obtenerProfesor($db, $idProfesor);
            if($profesor['ImgPerfilURL'] != './assets/img/perfiles/usuario.avif'){
                borrarImagen($profesor['ImgPerfilURL']);
            }

        } else {
            $_SESSION['error_general'] = "Error al subir la imagen.";
            header("Location: ../crear-profesor.php");
            exit();
        }
    } else {
        // Si no se sube nueva imagen, se mantiene la actual
        $profesor = obtenerProfesor($db, $idProfesor);
        $imgPerfilURL = $profesor['ImgPerfilURL'];
    }

    
    // Llamar a la función para crear el profesor
    try{
        crearProfesor($db, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL);
    }catch(Exception $e){
        $_SESSION['error_general'] = "Error al crear profesor.";
    }finally{
        // Redirige al usuario a la lista de profesores después de completar la operación.
        header("Location: ../profesores.php");
        exit();
    }
}