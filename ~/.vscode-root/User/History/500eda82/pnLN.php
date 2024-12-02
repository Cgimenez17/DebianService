<?php
session_start();

if (isset($_POST['token'], $_POST['email'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $newPassword = md5($_POST['new_password']); // Encriptar con MD5

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "devTP";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el token es válido
        $stmt = $conn->prepare("SELECT email FROM password_reset WHERE token = :token AND email = :email AND expires >= :now");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $now = date("U");
        $stmt->bindParam(':now', $now);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // Actualizar contraseña
            $stmt = $conn->prepare("UPDATE usuarios SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Eliminar token usado
            $stmt = $conn->prepare("DELETE FROM password_reset WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Mensaje de éxito
            $_SESSION['message'] = "¡Se envió un enlace para restablecer la contraseña!";
            $_SESSION['message_type'] = "success";

            header("Location: ../login.html");
            exit();
        } else {
            // Token inválido o expirado
            $_SESSION['message'] = "El enlace es inválido o ha expirado.";
            $_SESSION['message_type'] = "error";

            header("Location: reset_password.php?token=$token");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error en la conexión: " . $e->getMessage();
        $_SESSION['message_type'] = "error";

        header("Location: reset_password.php?token=$token");
        exit();
    }
} else {
    $_SESSION['message'] = "Solicitud inválida.";
    $_SESSION['message_type'] = "error";

    header("Location: reset_password.php");
    exit();
}
?>
