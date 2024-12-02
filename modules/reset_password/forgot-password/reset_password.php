<?php
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "devTP";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT email FROM password_reset WHERE token = :token AND expires >= :now");
        $stmt->bindParam(':token', $token);
        $now = date("U");
        $stmt->bindParam(':now', $now);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['email'];

            $_SESSION['message'] = "Enlace verificado correctamente.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "El enlace ha expirado o es inválido.";
            $_SESSION['message_type'] = "error";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error en la conexión: " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    }
} else {
    $_SESSION['message'] = "El enlace no es válido.";
    $_SESSION['message_type'] = "error";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Restablecer Contraseña</title>

    <!-- Custom fonts for this template-->
    <link href="../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Restablecer Contraseña</h1>
                                        <p class="mb-4">Si el enlace es válido, puedes ingresar tu nueva contraseña a continuación.</p>
                                    </div>

                                    
                                    <?php
                                    if (isset($_SESSION['message'])) {
                                        $messageType = $_SESSION['message_type'] === "success" ? "alert-success" : "alert-danger";
                                        echo '<div class="alert ' . $messageType . ' text-center" role="alert">' . $_SESSION['message'] . '</div>';
                                        unset($_SESSION['message']);
                                        unset($_SESSION['message_type']);
                                    }

                                    
                                    if (isset($email)) {
                                        echo '<form method="post" action="process_reset.php" class="user">
                                                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                                                <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                                                <div class="form-group">
                                                    <input type="password" name="new_password" class="form-control form-control-user" placeholder="Nueva Contraseña" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Restablecer Contraseña
                                                </button>
                                            </form>';
                                    }
                                    ?>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="../../../login.html">Volver al inicio de sesión</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../../js/sb-admin-2.min.js"></script>
</body>

</html>
