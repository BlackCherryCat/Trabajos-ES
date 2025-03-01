<?php
require_once 'includes/header.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: reserva.php");
}

// Verificar si hay mensajes de error o éxito
if (isset($_SESSION['error_general']) && !empty($_SESSION['error_general'])) {
    echo "<p class='error'>" . $_SESSION['error_general'] . "</p>";
    unset($_SESSION['error_general']);
}

if (isset($_SESSION['correcto']) && !empty($_SESSION['correcto'])) {
    echo "<p class='correcto'>" . $_SESSION['correcto'] . "</p>";
    unset($_SESSION['correcto']);
}

$idProfesor = $_GET['id'];

// Obtener los datos del profesor desde la base de datos
$profesor = obtenerProfesor($db, $idProfesor);

if (!$profesor) {
    echo "<p class='error'>Profesor no encontrado.</p>";
    exit;
}
?>

<h2>Modificar Profesor</h2>
<div class="form-container">
    <form action="./acciones/procesar-editar-profesor.php" method="POST" enctype="multipart/form-data">
        <!-- Campo oculto para el ID del profesor -->
        <input type="hidden" name="id" value="<?php echo $profesor['IdProfesor']; ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$"
                    title="Solo letras y espacios. Mínimo 2 y máximo 50 caracteres."
                    value="<?php echo htmlspecialchars($profesor['Nombre']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos"
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$"
                    title="Solo letras y espacios. Mínimo 2 y máximo 50 caracteres."
                    value="<?php echo htmlspecialchars($profesor['Apellidos']); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                    title="Debe ser un email válido (ejemplo@dominio.com)."
                    value="<?php echo htmlspecialchars($profesor['Email']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="passwd" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="passwd" name="passwd"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                    title="Mínimo 8 caracteres, al menos una mayúscula, una minúscula, un número y un carácter especial.">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="imgPerfil" class="form-label">Imagen de Perfil</label>
                <input type="file" class="form-control" id="imgPerfil" name="imgPerfil"
                    accept="image/png, image/jpeg, image/jpg">
            </div>
            <div class="col-md-3">
                <label class="form-label">Administrador</label>
                <select class="form-select" id="esAdmin" name="esAdmin">
                    <option value="1" <?php if($profesor['EsAdmin']) echo "selected" ?>>Sí</option>
                    <option value="0" <?php if(!$profesor['EsAdmin']) echo "selected" ?>>No</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select class="form-select" id="esAlta" name="esAlta">
                    <option value="1" <?php if($profesor['EsAlta']) echo "selected" ?>>Alta</option>
                    <option value="0" <?php if(!$profesor['EsAlta']) echo "selected" ?>>Baja</option>
                </select>
            </div>
        </div>

        <?php
        $cursosAsignaturas = obtenerCursosAsignaturas($db);
        $asignaturaPropias = obtenerCursoAsignaturaDelProfesor($db, $idProfesor);
        ?>

        <div>
            <label  class="form-label" for="clases">Selecciona las clases que imparte:</label>
            <select id="clases" name="clases[]" class="form-select" multiple="multiple">
            <?php
            // Recorrer las asignaturas y cursos
            foreach ($cursosAsignaturas as $linea) {
                // Crear el valor de la opción en formato "IdCurso-IdAsignatura"
                $valor = $linea['IdCurso'] . "-" . $linea['IdAsignatura'];

                // Verificar si la asignatura está seleccionada
                $selected = in_array($valor, $asignaturaPropias) ? "selected" : "";

                // Imprimir la opción
                echo "<option value='$valor' $selected>$linea[NombreCurso] - $linea[NombreAsignatura]</option>";
            }
        ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-4">Modificar Profesor</button>
    </form>
</div>



<?php require_once 'includes/footer.php'; ?>