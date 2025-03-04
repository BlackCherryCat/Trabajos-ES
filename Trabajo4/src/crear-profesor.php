<?php
require_once 'includes/header.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: reserva.php");
}

if (isset($_SESSION['error_general']) && !empty($_SESSION['error_general'])) {
    echo "<p class='error'>" . $_SESSION['error_general'] . "</p>";
    unset($_SESSION['error_general']);
}

if (isset($_SESSION['correcto']) && !empty($_SESSION['correcto'])) {
    echo "<p class='correcto'>" . $_SESSION['correcto'] . "</p>";
    unset($_SESSION['correcto']);
}
?>

<h2>Nuevo profesor</h2>
<div class="form-container">
    <form action="./acciones/procesar-crear-profesor.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$"
                    title="Solo letras y espacios. Mínimo 2 y máximo 50 caracteres."
                    required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos"
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,50}$"
                    title="Solo letras y espacios. Mínimo 2 y máximo 50 caracteres."
                    required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                    title="Debe ser un email válido (ejemplo@dominio.com)."
                    required>
            </div>
            <div class="col-md-6">
                <label for="passwd" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="passwd" name="passwd"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                    title="Mínimo 8 caracteres, al menos una mayúscula, una minúscula, un número y un carácter especial."
                    required>
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
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

        <button type="submit" class="btn btn-primary w-100 mt-4">Crear Profesor</button>
    </form>

</div>

<script>
    let icon = document.querySelector("i.fa");

    icon.addEventListener('click', showPass);

    function showPass(e){
        //Recuperamos el input pass
        let input = document.getElementById("passwd");

        if(e.target.classList.contains("fa-eye-slash")){
            input.setAttribute("type", "text");
            e.target.classList.remove("fa-eye-slash");
            e.target.classList.add("fa-eye");
        }else{
            input.setAttribute("type", "password");
            e.target.classList.remove("fa-eye");
            e.target.classList.add("fa-eye-slash");
        }
    }
</script>
<?php require_once 'includes/footer.php'; ?>