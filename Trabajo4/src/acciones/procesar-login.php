<?php
if (isset($_POST)) {
    require_once '../includes/conexion.php';
    require_once '../includes/funciones.php';
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST['password'];

    $login = login($db, $email);
    
    /*Como la funcion de password_hash cada vez que se ejecuta genera un hash diferente
    usaremos password_verify para comprobar el hash guardado en la bd con la contraseña pasada*/
    $verify = password_verify($password, $login['Passwd']);

    if ($verify && $login["EsAlta"] == 1) {
        // Utilizar una sesión para guardar los datos del usuario logueado
        $_SESSION['profesor'] = $login;
        header('Location: ../index.php');
        exit();
    } else {
        // Si algo falla enviar una sesión con el fallo
        $_SESSION['error_login'] = "Login incorrecto!!";
        header('Location: ../login.php');
    }
}

?>