<?php
require_once '../includes/redireccion.php';
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: ../index.php");
    exit();
}

// Comprueba si la solicitud HTTP es de tipo POST, lo que indica que el formulario fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $idProfesor = $_POST['id'];
    $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    if (empty($nombre)) {
        $_SESSION['error_general'] = "El nombre no puede estar vacío.";
        header("Location: ../editar-profesor.php?id=$idProfesor");
        exit();
    }
    
    $apellidos = htmlspecialchars(trim($_POST['apellidos']), ENT_QUOTES, 'UTF-8');
    if (empty($apellidos)) {
        $_SESSION['error_general'] = "Los apellidos no pueden estar vacíos.";
        header("Location: ../editar-profesor.php?id=$idProfesor");
        exit();
    }
    
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['error_general'] = "El email no es válido.";
        header("Location: ../editar-profesor.php?id=$idProfesor");
        exit();
    }

    // Si se ingresa una nueva contraseña, se encripta
    $passwd = !empty($_POST['passwd']) ? password_hash($_POST['passwd'], PASSWORD_BCRYPT) : null;
    
    $esAdmin = isset($_POST['esAdmin']) ? intval($_POST['esAdmin']) : 0;
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
            header("Location: ../editar-profesor.php?id=$idProfesor");
            exit();
        }
    } else {
        // Si no se sube nueva imagen, se mantiene la actual
        $profesor = obtenerProfesor($db, $idProfesor);
        $imgPerfilURL = $profesor['ImgPerfilURL'];
    }

        //Curso-Asignatura del profesor a editar
        if (isset($_POST["clases"])) {
        $clasesSeleccionadas = $_POST["clases"]; // Array de valores tipo "1-1", "2-3", etc.
        try{
            actualizarProfesorCursoAsignatura($db, $idProfesor, $clasesSeleccionadas);
        }catch (Exception $e){
            $_SESSION['error_general'] = "Error al actualizar el profesor en las asignaturas.";
        }
        
        }

    // Actualización de los datos del profesor
    try {
        actualizarProfesor($db, $idProfesor, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL);
        if($idProfesor == $_SESSION['profesor']['IdProfesor']){
            $_SESSION['profesor']['ImgPerfilURL'] = $imgPerfilURL;
            $_SESSION['correcto'] = "Perfil cambiado con exito.";
            header("Location: ../profesores.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_general'] = "Error al actualizar el profesor.";
    } finally {
        header("Location: ../profesores.php");
        exit();
    }
}
?>
