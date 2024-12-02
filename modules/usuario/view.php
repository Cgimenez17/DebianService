<?php
// Iniciar la sesión
session_start();

// Verificar si la sesión es válida
if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
    echo "<script>
            alert('Token de sesión inválido, serás redirigido al inicio de sesión');
            window.location.href = '../../login.html';
          </script>";
    exit();
}

// Conexión a la base de datos
include '../../config/database.php';

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'];

// Consultar los datos del usuario autenticado desde la base de datos
$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username = '$username'")
    or die('Error: ' . mysqli_error($mysqli));

// Obtener los datos del usuario autenticado
$auth_user = mysqli_fetch_assoc($query);

// Verificar si se encontraron datos del usuario
if (!$auth_user) {
    // Si no se encuentra al usuario, destruir la sesión y redirigir al login
    session_destroy();
    echo "<script>
            alert('Usuario no encontrado, serás redirigido al inicio de sesión');
            window.location.href = '../../login.html';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Perfil de Usuario">
    <meta name="author" content="">

    <title>Perfil de Usuario</title>

    <!-- Estilos -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Debian Service</div>
            </a>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="view.php">
                    <i class="fas fa-user"></i>
                    <span>Perfil</span>
                </a>
            </li>
        </ul>
        <!-- Fin del Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo htmlspecialchars($auth_user['name_user']); ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- Fin del Topbar -->

                

                <!-- Contenido Principal -->
                <div class="container-fluid">

                    <!-- Título de Página -->
                    <h1 class="h3 mb-4 text-gray-800">Perfil de Usuario</h1>

                    <!-- Información del Usuario -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información Personal</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg" width="100%">
                                </div>
                                <div class="col-md-9">
                                    <h4><?php echo htmlspecialchars($auth_user['name_user']); ?></h4>
                                    <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($auth_user['username']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($auth_user['email']); ?></p>
                                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($auth_user['telefono']); ?></p>
                                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($auth_user['status']); ?></p>
                                    <a href="../../index.php" class="btn btn-primary">Inicio</a> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin del Contenido Principal -->
            </div>
            <!-- Fin del Main Content -->

            

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Debian Service 2024</span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- Fin del Content Wrapper -->
    </div>
    <!-- Fin del Page Wrapper -->

    <!-- Scripts -->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
</body>

</html>
