<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/vendor/autoload.php'; // Cargar PHPMailer automáticamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mi_base_de_datos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el correo existe en la base de datos
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // Generar token único
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800; // 30 minutos de validez

            // Guardar el token en la base de datos
            $stmt = $conn->prepare("INSERT INTO password_reset (email, token, expires) VALUES (:email, :token, :expires)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expires);
            $stmt->execute();

            // Enviar el correo con el enlace
            $resetLink = "http://tu_dominio/reset_password.php?token=" . $token;

            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'TU_CORREO@gmail.com'; // Tu correo
                $mail->Password = 'TU_CONTRASEÑA_DE_APLICACIÓN'; // Contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración del correo
                $mail->setFrom('TU_CORREO@gmail.com', 'Tu Nombre o Empresa');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Restablecer tu contraseña';
                $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                echo 'Se ha enviado un correo para restablecer tu contraseña.';
            } catch (Exception $e) {
                echo 'No se pudo enviar el correo. Error: ' . $mail->ErrorInfo;
            }
        } else {
            echo 'El correo no está registrado.';
        }
    } catch (PDOException $e) {
        echo 'Error en la conexión: ' . $e->getMessage();
    }
}
?>
