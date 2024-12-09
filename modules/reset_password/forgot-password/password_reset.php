<?php
session_start(); // Iniciar la sesión

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); 

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
            $_SESSION['message'] = "Error en la consulta: " . $e->getMessage();
            $_SESSION['message_type'] = "error";
            header("Location: forgot_password.php");
            exit();
        }

        if ($stmt->rowCount() === 1) {
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800;

            $stmt = $conn->prepare("INSERT INTO password_reset (email, token, expires) VALUES (:email, :token, :expires)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expires);
            $stmt->execute();

            $resetLink = "http://localhost/debian/modules/reset_password/forgot-password/reset_password.php?token=" . $token;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cgimenezzz17@gmail.com';
                $mail->Password = 'ozqz xsuz cqxg gcld';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('cgimenezzz17@gmail.com', 'DebianDEV');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Restablecer tu contraseña';
                $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                $_SESSION['message'] = "Se ha enviado un correo para restablecer tu contraseña.";
                $_SESSION['message_type'] = "success";
                header("Location: ../../../login.html");
                exit();
            } catch (Exception $e) {
                $_SESSION['message'] = "No se pudo enviar el correo. Error: " . $mail->ErrorInfo;
                $_SESSION['message_type'] = "error";
                header("Location: forgot-password.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "El correo no está registrado.";
            $_SESSION['message_type'] = "error";
            header("Location: forgot-password.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error en la conexión: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
        header("Location: forgot-password.php");
        exit();
    }
}
?>
