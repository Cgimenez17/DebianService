<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mi_base_de_datos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el token es válido
        $stmt = $conn->prepare("SELECT email FROM password_reset WHERE token = :token AND expires >= :now");
        $stmt->bindParam(':token', $token);
        $now = date("U");
        $stmt->bindParam(':now', $now);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // Token válido, mostrar formulario
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['email'];

            echo '<form method="post" action="process_reset.php">
                    <input type="hidden" name="email" value="' . $email . '">
                    <input type="hidden" name="token" value="' . $token . '">
                    <label>Nueva Contraseña:</label>
                    <input type="password" name="new_password" required>
                    <button type="submit">Restablecer Contraseña</button>
                  </form>';
        } else {
            echo 'El enlace ha expirado o es inválido.';
        }
    } catch (PDOException $e) {
        echo 'Error en la conexión: ' . $e->getMessage();
    }
}
?>
