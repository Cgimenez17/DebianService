<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // Limpiar espacios en blanco

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "devTP";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id_user FROM usuarios WHERE LOWER(email) = LOWER(:email)");
        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }

        if ($stmt->rowCount() === 1) {
            echo "Correo encontrado.<br>";
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800;

            $stmt = $conn->prepare("INSERT INTO password_reset (email, token, expires) VALUES (:email, :token, :expires)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expires);
            $stmt->execute();

            $resetLink = "http://localhost/debian/reset_password.php?token=" . $token;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cgimenezzz17@gmail.com';
                $mail->Password = 'ndqr lukd ryzm ncfc';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('cgimenezzz17@gmail.com', 'DebianDEV');
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
