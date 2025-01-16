<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center mb-4">Formulario de Contacto</h1>
                <form action="send_mail.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Asunto del mensaje" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    // Activar o desactivar excepciones mediante variable
    $debug = true;
    try {
        // Crear instancia de la clase PHPMailer
        $mail = new PHPMailer($debug);
        if ($debug) {
            // Genera un registro detallado
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        }
        // Autentificación con SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        // Login
        $mail->Host = "smtp.domain.es";
        $mail->Port = 587;
        $mail->Username = "nombre.apellido@domain.es";
        $mail->Password = "ejemplocontraseña1234";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('info@example.com', 'name');
        $mail->addAddress('info@example.com', 'name');
        $mail->addAttachment("/home/user/Escritorio/imagendeejemplo.png", "imagendeejemplo.png");
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Subject = 'Asunto de tu correo';
        $mail->Body = 'El contenido de tu correo en HTML. Los elementos en <b>negrita</b> también están permitidos.';
        $mail->AltBody = 'Texto como elemento de texto simple';
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: ".$e->getMessage();
    }
?>