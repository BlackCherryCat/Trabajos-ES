<?php

// Obtener los profesores BD
function obtenerProfesores($conexion) {
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

function obtenerBusquedaProfesores($conexion, $busqueda = null) {
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

function login($conexion, $email){
    $consulta = "SELECT * FROM profesores WHERE Email = '$email';";
    $resultado = mysqli_query($conexion, $consulta);

    $login = array();
    if ($resultado && mysqli_num_rows($resultado) == 1) {
        // Recorrer cada fila del resultado y almacenarla en el array
        $login = mysqli_fetch_assoc($resultado);
    }
    return $login; // Devolver el array con los profesores
}

?>