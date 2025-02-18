<?php require_once './includes/conexion.php';
//$password_cifrada = password_hash("1234", PASSWORD_DEFAULT, ['cost'=>10]);
//echo $password_cifrada;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-card">
        <h3>Iniciar sesión</h3>
        <form action="./acciones/procesar-login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Ingrese su correo" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Ingresar</button>
            <?php
            if (isset($_SESSION['error_login']) && !empty($_SESSION['error_login'])) {
                echo "<p class='error'>".$_SESSION['error_login']."</p>";
                unset($_SESSION['error_login']);
            }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>