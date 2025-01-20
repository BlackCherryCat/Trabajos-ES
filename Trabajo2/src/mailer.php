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

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        $mail->addAddress('trabajoes786@gmail.com', 'Cris');

        $mail->isHTML(true);
        $mail->Subject = 'Asunto de tu correo';
        $mail->Body    = 'El contenido de tu correo en HTML. Los elementos en <b>negrita</b> también están permitidos.';
    
        $mail->send();
        echo 'Correo enviado correctamente';
        
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    }
    
    
?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>