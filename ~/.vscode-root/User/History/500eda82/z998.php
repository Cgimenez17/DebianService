<?php
if (isset($_POST['token'], $_POST['email'], $_POST['new_password'])) {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mi_base_de_datos";

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

            echo 'Contraseña actualizada correctamente.';
        } else {
            echo 'El enlace es inválido o ha expirado.';
        }
    } catch (PDOException $e) {
        echo 'Error en la conexión: ' . $e->getMessage();
    }
}
?>
