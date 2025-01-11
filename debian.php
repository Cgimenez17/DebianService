

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Marcar Asistencia</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="css/sb-admin-2.css" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="toast-container"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar >
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            < Sidebar - Brand >
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><sup></sup></div>

            </a>


        </ul>
        <End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar>
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <Sidebar Toggle (Topbar)>
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>




                </nav>
                <End of Topbar -->

                <!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column justify-content-center align-items-center" style="height: 100vh; margin: 0; padding: 0;">
    <!-- Título -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Bienvenido!</h1>

    <!-- Botones -->
    <div class="col-md-6">
        <button onclick="window.location.href='login.html'" class="btn btn-primary btn-block mb-3">Iniciar sesión</button>
        <button onclick="window.location.href='modules/RRHH/empleados/Asistencias/view.php'" class="btn btn-primary btn-block">Registrar asistencias/salida</button>
    </div>
</div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Debian Dev's César - 2025</span>
                    </div>
                </div>
            </footer>
            < End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>