<?php
// Iniciar la sesión
session_start();
include '../../../../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sanciones</title>

    <!-- Custom fonts for this template-->
    <link href="../../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="../../../../css/sb-admin-2.css" rel="stylesheet">

    <link href="../../../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="toast-container"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../../../debian.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Inicio de Sesión <sup></sup></div>

            </a>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>




                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Registrar Sanción a empleado</h1>
                    </div>


                    <!-- DataTable -->
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">

                                <!-- Formulario de cambio de contraseña -->
                                <!-- Formulario de registro de sanción -->
                                <form role="form" class="form-horizontal" action="proses.php" method="POST" id="form-registrar-sancion">
                                    <div class="form-group">
                                        <label for="ci_asis">Ingrese el CI del empleado</label>
                                        <input type="text" class="form-control" id="ci_asis" name="ci_asis" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_sancion">Seleccione el tipo de sanción:</label>
                                        <select class="form-control" id="tipo_sancion" name="tipo_sancion" required>
                                            <?php
                                            // Consulta para obtener los tipos de sanción
                                            $query = "SELECT id_tipo_sancion, descripcion FROM tiposancion";
                                            $result = mysqli_query($mysqli, $query);

                                            // Validar si se encontraron resultados
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_tipo_sancion'] . '">' . $row['descripcion'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No hay tipos de sanción disponibles</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_permiso">Ingrese el motivo</label>
                                        <input type="text" class="form-control" id="txt_permiso" name="txt_permiso" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_permiso">Desde:</label>
                                        <input type="date" class="form-control" id="fecha_permiso" name="fecha_permiso" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_permisofin">Hasta:</label>
                                        <input type="date" class="form-control" id="fecha_permisofin" name="fecha_permisofin" required>
                                    </div>
                                    <button type="submit" name="guardarSancion" class="btn btn-primary btn-block">Registrar Sanción</button>
                                </form>


                                <!-- Mensajes de alerta -->
                                <?php
                                if (!empty($_GET['alert'])) {
                                    switch ($_GET['alert']) {
                                        case 'successSancion':
                                            echo "<div class='alert alert-success'>Permiso registrado correctamente.</div>";
                                            break;
                                        case 'errorDuplicatedSancion':
                                            echo "<div class='alert alert-warning'>Ya has registrado una sanción en esas fechas.</div>";
                                            break;


                                        case 'NotAnEmployee':
                                            echo "<div class='alert alert-danger'>No existe el empleado solicitado</div>";
                                            break;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>




                    <style>
                        .form-container {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            min-height: 100vh;
                        }
                    </style>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Debian Dev by César - 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script src="../../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../../../js/sb-admin-2.min.js"></script>
    <script src="../../../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>