<?php
session_start();

if (isset($_POST['token'], $_POST['email'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $newPassword = md5($_POST['new_password']); 

    
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
            
            $stmt1 = $conn->prepare("UPDATE usuarios SET password = :password, status='activo' WHERE email = :email");
            $stmt1->bindParam(':password', $newPassword);
            $stmt1->bindParam(':email', $email);
            $stmt1->execute(); //Hace el update de la contraseña

            $stmt2 = $conn->prepare("UPDATE empleados SET estado = 'activo' WHERE email = :email");
            $stmt2->bindParam(':email', $email);
            $stmt2->execute(); //Al resetear la contraseña activa el empleado para hacer el login

            
            $stmt3 = $conn->prepare("DELETE FROM password_reset WHERE email = :email");
            $stmt3->bindParam(':email', $email);
            $stmt3->execute(); //Borra el caché del token

            
            $_SESSION['message'] = "¡Contraseña actualizada correctamente!";
            $_SESSION['message_type'] = "success";

            header("Location: ../../../login.html");
            exit();
        } else {
            
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
