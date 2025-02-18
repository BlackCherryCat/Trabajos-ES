<?php
require_once 'includes/header.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: index.php");
}

if (isset($_SESSION['error_general']) && !empty($_SESSION['error_general'])) {
    echo "<p class='error'>" .$_SESSION['error_general']."</p>";
    unset($_SESSION['error_general']);
}

if (isset($_SESSION['correcto']) && !empty($_SESSION['correcto'])) {
    echo "<p class='correcto'>" .$_SESSION['correcto']."</p>";
    unset($_SESSION['correcto']);
}


?>
<h2>Nuevo profesor</h2>
<div class="form-container">
    <form action="./acciones/procesar-crear-profesor.php" method="POST">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="passwd" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="passwd" name="passwd" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="imgPerfil" class="form-label">Imagen de Perfil</label>
                <input type="file" class="form-control" id="imgPerfil" name="imgPerfil" accept="image/*" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Administrador</label>
                <select class="form-select" id="esAdmin" name="esAdmin">
                    <option value="1">Sí</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select class="form-select" id="esAlta" name="esAlta">
                    <option value="1" selected>Alta</option>
                    <option value="0">Baja</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Crear Profesor</button>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>