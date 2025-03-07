<?php
require_once '../includes/redireccion.php';
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

// Comprueba si la solicitud HTTP es de tipo POST, lo que indica que el formulario fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $idProfesor = $_SESSION['profesor']['IdProfesor'];
    $esAlta = $_SESSION['profesor']['EsAlta'];
    $esAdmin = $_SESSION['profesor']['EsAdmin'];
    $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $_SESSION['profesor']['Nombre'] = $nombre;
    if (empty($nombre)) {
        $_SESSION['error_general'] = "El nombre no puede estar vacío.";
        header("Location: ../mi-perfil.php");
        exit();
    }
    
    $apellidos = htmlspecialchars(trim($_POST['apellidos']), ENT_QUOTES, 'UTF-8');
    if (empty($apellidos)) {
        $_SESSION['error_general'] = "Los apellidos no pueden estar vacíos.";
        header("Location: ../mi-perfil.php");
        exit();
    }
    
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['error_general'] = "El email no es válido.";
        header("Location: ../mi-perfil.php");
        exit();
    }

    // Si se ingresa una nueva contraseña, se encripta
    $passwd = !empty($_POST['passwd']) ? password_hash($_POST['passwd'], PASSWORD_BCRYPT) : null;

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
            header("Location: ../mi-perfil.php");
            exit();
        }
    } else {
        // Si no se sube nueva imagen, se mantiene la actual
        $profesor = obtenerProfesor($db, $idProfesor);
        $imgPerfilURL = $profesor['ImgPerfilURL'];
    }

    // Actualización de los datos del profesor
    try {
        actualizarProfesor($db, $idProfesor, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL);
        $_SESSION['profesor']['ImgPerfilURL'] = $imgPerfilURL;
        $_SESSION['correcto'] = "Perfil cambiado con exito. Vuelva a loguearse para ver los cambios aplicados.";
        header("Location: ../mi-perfil.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error_general'] = "Error al actualizar el profesor.";
        header("Location: ../mi-perfil.php");
        exit();
    }
}
?>
