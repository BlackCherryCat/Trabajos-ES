<?php

// Obtener los profesores BD
function obtenerProfesores($conexion)
{
    // Consulta SQL para seleccionar todos los profesores
    $consulta = "SELECT * FROM profesores;";
    $resultado = mysqli_query($conexion, $consulta); // Ejecutar la consulta

    $profesores = array();
    if ($resultado && mysqli_num_rows($resultado) >= 1) {
        // Recorrer cada fila del resultado y almacenarla en el array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $profesores[] = $fila; // Agregar cada profesor al array
        }
    }
    return $profesores; // Devolver el array con los profesores
}

// Obtener un profesor por ID desde la BD (con consulta directa)
function obtenerProfesor($conexion, $idProfesor)
{
    // Sanitizar el ID para evitar inyecciones SQL (convertirlo a entero)
    $idProfesor = (int)$idProfesor;

    // Consulta SQL para seleccionar el profesor con el ID especificado
    $consulta = "SELECT * FROM profesores WHERE IdProfesor = $idProfesor";
    
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta se ejecutó correctamente y si se encontró un profesor
    if ($resultado && mysqli_num_rows($resultado) == 1) {
        // Obtener el profesor de la consulta
        $profesor = mysqli_fetch_assoc($resultado);
    } else {
        // Si no se encuentra el profesor
        $profesor = null;
    }

    return $profesor; // Devolver el profesor encontrado o null
}

function obtenerBusquedaProfesores($conexion, $busqueda = null)
{
    // Consulta SQL para seleccionar todos los profesores que contengan la busqueda en el nombre o apellidos
    $consulta = "SELECT * FROM profesores WHERE Nombre LIKE '%$busqueda%' OR Apellidos LIKE '%$busqueda%';";
    $resultado = mysqli_query($conexion, $consulta); // Ejecutar la consulta

    $profesores = array();
    if ($resultado && mysqli_num_rows($resultado) >= 1) {
        // Recorrer cada fila del resultado y almacenarla en el array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $profesores[] = $fila; // Agregar cada profesor al array
        }
    }
    return $profesores; // Devolver el array con los profesores
}

function login($conexion, $email)
{
    $consulta = "SELECT * FROM Profesores WHERE Email = '$email';";
    $resultado = mysqli_query($conexion, $consulta);

    $login = array();
    if ($resultado && mysqli_num_rows($resultado) == 1) {
        // Recorrer cada fila del resultado y almacenarla en el array
        $login = mysqli_fetch_assoc($resultado);
    }
    return $login; // Devolver el array con los profesores
}

function borrarProfesor($conexion, $idProfesor)
{
    // Proceder con la eliminación y verificar si se eliminó alguna fila
    $consulta = "DELETE FROM profesores WHERE IdProfesor = $idProfesor";
    $borrar = mysqli_query($conexion, $consulta);

    if ($borrar && mysqli_affected_rows($conexion) == 1) {
        $_SESSION['correcto'] = "Profesor borrado con éxito";
    } else {
        $_SESSION['error_general'] = "El profesor con ID $idProfesor no existe o no pudo ser borrado.";
    }
}

function crearProfesor($conexion, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL)
{
    $consulta = "INSERT INTO profesores (Nombre, Apellidos, Email, Passwd, EsAdmin, EsAlta, ImgPerfilURL) VALUES ('$nombre', '$apellidos', '$email', '$passwd', '$esAdmin', '$esAlta', '$imgPerfilURL')";
    $insertar = mysqli_query($conexion, $consulta);

    if ($insertar) {
        $_SESSION['correcto'] = "Profesor creado con éxito";
    }
}

function subirImagen($fichero)
{
    // RUTA DONDE SE GUARDARÁ EL ARCHIVO SUBIDO
    $ruta = "../assets/img/perfiles/";

    // Recogemos la información del fichero subido
    $nombreFich = $fichero["name"];   // Nombre del archivo
    $tempFich = $fichero["tmp_name"]; // Ruta temporal
    $sizeFich = $fichero["size"];     // Tamaño
    $tipoFich = $fichero["type"];     // Tipo MIME

    // Comprobar que el tamaño no exceda los 1 MB
    $maxSize = 2 * 1024 * 1024; // 1 MB en bytes

    // Mover el archivo subido a la carpeta del servidor "subidasFile"
    // Mostrar el archivo subido
    $rutaDestino = $ruta . basename($nombreFich); // Ruta de destino

    // Lista de tipos MIME permitidos
    $tiposPermitidos = ["image/jpeg", "image/png"];

    if (!in_array($tipoFich, $tiposPermitidos)) {
        $_SESSION['error_general'] = "Error: Solo se permiten imágenes en formato JPG o PNG.";
    } elseif ($sizeFich > $maxSize) {
        $_SESSION['error_general'] = "Error: El archivo es demasiado grande (máximo: 1 MB).";
    } elseif (move_uploaded_file($tempFich, $rutaDestino)) {
        return true;
    } else {
        $_SESSION['error_general'] = "Error: No se pudo subir el archivo.";
    }
    return false;
}

function borrarImagen($fichero)
{
    $ruta = "../assets/img/perfiles/";
    $imagen = $ruta . basename($fichero);

    if (file_exists($imagen)) {
        if (unlink($imagen)) {
            echo "Imagen eliminada con éxito.";
        } else {
            echo "Error al eliminar la imagen.";
        }
    } else {
        echo "La imagen no existe.";
    }
}

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($destinatario, $asunto, $mensaje)
{

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'trabajoes786@gmail.com';
        $mail->Password = 'ykic ohip fxlf epsf';  // Usar contraseña de aplicación si es necesario
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Usar SSL
        $mail->Port = 465;  // Puerto para SSL

        $mail->setFrom('trabajoes786@gmail.com', 'Trabajo');
        $mail->addAddress("$destinatario", 'Destinatario');

        $mail->isHTML(true);
        $mail->Subject = "$asunto";
        $mail->Body    = "$mensaje";

        $mail->send();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


require_once 'FPDF/fpdf.php';

function descargarPDF($datos, $nombreArchivo = 'mireserva.pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Datos de la reserva', 0, 1, 'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 12);
    foreach ($datos as $clave => $valor) {
        $pdf->Cell(0, 10, "$clave: $valor", 0, 1);
    }
    
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
    $pdf->Output('D', $nombreArchivo);
    exit;
}
