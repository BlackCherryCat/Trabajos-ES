<?php

// Obtener los profesores BD
function obtenerProfesores($conexion)
{
    // Consulta SQL para seleccionar todos los profesores
    $consulta = "SELECT * FROM Profesores;";
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
    $consulta = "SELECT * FROM Profesores WHERE IdProfesor = $idProfesor";

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

function actualizarProfesor($conexion, $idProfesor, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL)
{
    // Primero, obtenemos los datos actuales del profesor
    $profesorActual = obtenerProfesor($conexion, $idProfesor);

    // Iniciar la construcción de la consulta UPDATE
    $consulta = "UPDATE Profesores SET ";

    $camposActualizados = []; // Array para almacenar los campos que realmente serán actualizados

    // Comprobar si el nombre ha cambiado
    if ($nombre !== $profesorActual['Nombre']) {
        $nombre = mysqli_real_escape_string($conexion, trim($nombre)); // Sanitizar
        $camposActualizados[] = "Nombre = '$nombre'";
    }

    // Comprobar si los apellidos han cambiado
    if ($apellidos !== $profesorActual['Apellidos']) {
        $apellidos = mysqli_real_escape_string($conexion, trim($apellidos)); // Sanitizar
        $camposActualizados[] = "Apellidos = '$apellidos'";
    }

    // Comprobar si el email ha cambiado
    if ($email !== $profesorActual['Email']) {
        $camposActualizados[] = "Email = '$email'";
    }

    if ($esAdmin !== $profesorActual['EsAdmin']) {
        $camposActualizados[] = "EsAdmin = '$esAdmin'";
    }

    if ($esAlta !== $profesorActual['EsAlta']) {
        $camposActualizados[] = "EsAlta = '$esAlta'";
    }

    // Comprobar si la imagen de perfil ha cambiado
    if ($imgPerfilURL !== $profesorActual['ImgPerfilURL']) {
        $camposActualizados[] = "ImgPerfilURL = '$imgPerfilURL'";
    }

    // Comprobar si la contraseña ha cambiado
    if ($passwd !== null && $passwd != $profesorActual['Passwd']) {
        $camposActualizados[] = "Passwd = '$passwd'";
    }

    // Si al menos un campo ha cambiado, actualizamos la base de datos
    if (!empty($camposActualizados)) {
        // Unir todos los campos actualizados con coma
        $consulta .= implode(", ", $camposActualizados);
        $consulta .= " WHERE IdProfesor = $idProfesor"; // Añadir la condición de ID

        // Ejecutar la consulta de actualización
        $actualizacion = mysqli_query($conexion, $consulta);

        if ($actualizacion) {
            $_SESSION['correcto'] = "Profesor actualizado con éxito";
        } else {
            $_SESSION['error_general'] = "Error al actualizar el profesor.";
        }
    }
    return true; // No hubo cambios, por lo que no se realiza ninguna actualización
}


function obtenerBusquedaProfesores($conexion, $busqueda = null)
{
    // Consulta SQL para seleccionar todos los profesores que contengan la busqueda en el nombre o apellidos
    $consulta = "SELECT * FROM Profesores WHERE Nombre LIKE '%$busqueda%' OR Apellidos LIKE '%$busqueda%';";
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
    $consulta = "DELETE FROM Profesores WHERE IdProfesor = $idProfesor";
    $borrar = mysqli_query($conexion, $consulta);

    if ($borrar && mysqli_affected_rows($conexion) == 1) {
        $_SESSION['correcto'] = "Profesor borrado con éxito";
    } else {
        $_SESSION['error_general'] = "El profesor con ID $idProfesor no existe o no pudo ser borrado.";
    }
}


function obtenerReservas($db)
{
    $sql = "SELECT r.IdReserva, r.Fecha,
                CONCAT(SUBSTRING_INDEX(MIN(t.Horario), '-', 1), ' - ', SUBSTRING_INDEX(MAX(t.Horario), '-', -1)) AS Horario,
                CONCAT(p.Nombre, ' ', p.Apellidos) AS Profesor,
                r.NumAlumnos, c.Nombre AS Curso, a.Nombre AS Asignatura
            FROM Reservas r
            JOIN Reserva_Tramos rt ON r.IdReserva = rt.IdReserva
            JOIN Tramos t ON rt.IdTramo = t.IdTramo
            JOIN Profesores p ON r.IdProfesor = p.IdProfesor
            JOIN Cursos c ON r.IdCurso = c.IdCurso
            JOIN Asignaturas a ON r.IdAsignatura = a.IdAsignatura
            GROUP BY r.IdReserva
            ORDER BY r.Fecha ASC;";

    $result = mysqli_query($db, $sql);
    $reservas = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $reservas[] = $row;
    }

    return $reservas;
}

function crearProfesor($conexion, $nombre, $apellidos, $email, $passwd, $esAdmin, $esAlta, $imgPerfilURL)
{
    $consulta = "INSERT INTO Profesores (Nombre, Apellidos, Email, Passwd, EsAdmin, EsAlta, ImgPerfilURL) VALUES ('$nombre', '$apellidos', '$email', '$passwd', '$esAdmin', '$esAlta', '$imgPerfilURL')";
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
    // Crear un nombre único para la imagen
    $extension = pathinfo($nombreFich, PATHINFO_EXTENSION);  // Obtener la extensión del archivo (jpg, png, etc.)
    $nombreUnico = uniqid('img_', true) . '.' . $extension;  // Generar un nombre único usando `uniqid` y la extensión original

    $rutaDestino = $ruta . $nombreUnico;  // Ruta de destino con el nuevo nombre único

    // Lista de tipos MIME permitidos
    $tiposPermitidos = ["image/jpeg", "image/png"];

    if (!in_array($tipoFich, $tiposPermitidos)) {
        $_SESSION['error_general'] = "Error: Solo se permiten imágenes en formato JPG o PNG.";
    } elseif ($sizeFich > $maxSize) {
        $_SESSION['error_general'] = "Error: El archivo es demasiado grande (máximo: 1 MB).";
    } elseif (move_uploaded_file($tempFich, $rutaDestino)) {
        $_SESSION['profesor']['ImgPerfilURL'] = $rutaDestino;
        return $nombreUnico;
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

require_once 'FPDF/fpdf.php';

function descargarPDF($op, $db, $id, $nombreArchivo = 'mireserva.pdf')
{
    $sql = "SELECT 
        r.IdReserva,
        r.Fecha,
        t.Horario,
        r.NumAlumnos,
        c.Nombre AS Curso,
        a.Nombre AS Asignatura,
        p.Nombre AS Nombre,
        p.Apellidos AS Apellidos
        FROM Reservas r
        JOIN Cursos c ON r.IdCurso = c.IdCurso
        JOIN Asignaturas a ON r.IdAsignatura = a.IdAsignatura
        JOIN Profesores p ON r.IdProfesor = p.IdProfesor
        JOIN Reserva_Tramos rt ON r.IdReserva = rt.IdReserva
        JOIN Tramos t ON rt.IdTramo = t.IdTramo
        WHERE r.IdReserva = $id;
";
    $resultado = $db->query($sql);
    $fila = $resultado->fetch_assoc();
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Datos de la reserva', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "ID Reserva: " . $fila['IdReserva'], 0, 1);
    $pdf->Cell(0, 10, "Nombre y apellidos: " . mb_convert_encoding($fila['Nombre'], 'ISO-8859-1') . " " . mb_convert_encoding($fila['Apellidos'], 'ISO-8859-1'), 0, 1);
    $pdf->Cell(0, 10, "Fecha: " . $fila['Fecha'], 0, 1);
    $pdf->Cell(0, 10, mb_convert_encoding("Número de alumnos: ", 'ISO-8859-1') . $fila['NumAlumnos'], 0, 1);
    $pdf->Cell(0, 10, "Curso: " . mb_convert_encoding($fila['Curso'], 'ISO-8859-1'), 0, 1);
    $pdf->Cell(0, 10, "Asignatura: " . mb_convert_encoding($fila['Asignatura'], 'ISO-8859-1'), 0, 1);
    // Imprimir los tramos (se recorrerá nuevamente para incluir todos)
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Tramos:", 0, 1);
    // Resetear el puntero del resultado y recorrer todas las filas
    $resultado->data_seek(0);
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Tramo: " . $fila['Horario'], 0, 1);
    }

    header('Content-Type: application/pdf');
    header("Content-Disposition: inline; filename=\"$nombreArchivo\"");
    if ($op == 'D') {
        $pdf->Output('D', $nombreArchivo);
    } else {
        $pdf->Output('I', $nombreArchivo);
    }
    exit;
}

function obtenerCursosAsignaturas($conexion)
{
    // Consulta SQL para seleccionar todos los profesores
    $consulta = "SELECT ca.IdCurso,
                    c.Nombre AS NombreCurso,
                    ca.IdAsignatura,
                    a.Nombre AS NombreAsignatura
                FROM Curso_Asignatura ca
                JOIN Cursos c ON ca.IdCurso = c.IdCurso
                JOIN Asignaturas a ON ca.IdAsignatura = a.IdAsignatura;
                ";
    $resultado = mysqli_query($conexion, $consulta); // Ejecutar la consulta

    $cusrosAsignaturas = array();
    if ($resultado && mysqli_num_rows($resultado) >= 1) {
        // Recorrer cada fila del resultado y almacenarla en el array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $cusrosAsignaturas[] = $fila; // Agregar cada profesor al array
        }
    }
    return $cusrosAsignaturas; // Devolver el array con los profesores
}

function actualizarProfesorCursoAsignatura($conexion, $idProfesor, $clasesSeleccionadas)
{
    // Verificar que $clasesSeleccionadas sea un array, si no, asignar un array vacío
    if (!is_array($clasesSeleccionadas)) {
        $clasesSeleccionadas = [];
    }

    // Obtener las asignaciones actuales del profesor desde la base de datos en el mismo formato "curso-asignatura"
    $asignaturasActuales = obtenerCursoAsignaturaDelProfesor($conexion, $idProfesor); // Retorna ["1-1", "2-3"]

    // **Determinar qué asignaciones eliminar**
    $asignacionesEliminar = array_diff($asignaturasActuales, $clasesSeleccionadas);

    // **Determinar qué asignaciones insertar**
    $asignacionesInsertar = array_diff($clasesSeleccionadas, $asignaturasActuales);

    // **Eliminar asignaciones que ya no están en la nueva lista**
    if (!empty($asignacionesEliminar)) {
        foreach ($asignacionesEliminar as $clase) {
            list($idCurso, $idAsignatura) = explode("-", $clase);
            $idCurso = intval($idCurso);
            $idAsignatura = intval($idAsignatura);
            $sqlDelete = "DELETE FROM Profesor_Curso_Asignatura
                        WHERE IdProfesor = $idProfesor
                        AND IdCurso = $idCurso
                        AND IdAsignatura = $idAsignatura";
            mysqli_query($conexion, $sqlDelete);
        }
    }

    // **Insertar nuevas asignaciones**
    if (!empty($asignacionesInsertar)) {
        foreach ($asignacionesInsertar as $clase) {
            list($idCurso, $idAsignatura) = explode("-", $clase);
            $idCurso = intval($idCurso);
            $idAsignatura = intval($idAsignatura);
            $sqlInsert = "INSERT INTO Profesor_Curso_Asignatura (IdCurso, IdAsignatura, IdProfesor) 
                        VALUES ($idCurso, $idAsignatura, $idProfesor)";
            mysqli_query($conexion, $sqlInsert);
        }
    }
}


function obtenerCursoAsignaturaDelProfesor($conexion, $idProfesor)
{
    $consulta = "SELECT IdCurso, IdAsignatura
            FROM Profesor_Curso_Asignatura
            WHERE IdProfesor = " . (int)$idProfesor;

    $resultado = mysqli_query($conexion, $consulta); // Ejecutar la consulta

    // Convertir los resultados en un array de strings "IdCurso-IdAsignatura"
    // Verificar si hay resultados
    if (mysqli_num_rows($resultado) > 0) {
        $asignaturasProfesor = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $asignaturasProfesor[] = $fila['IdCurso'] . "-" . $fila['IdAsignatura']; // Formato "1-1"
        }
        return $asignaturasProfesor;
    } else {
        return []; // Si no hay resultados, devolver un array vacío
    }
}
