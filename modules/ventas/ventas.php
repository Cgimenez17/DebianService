<?php
// Conexión a la base de datos
require_once '../../config/database.php'; // Asegúrate de incluir tu archivo de configuración de base de datos

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Debian Ventas</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

 <!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Debian service <sup></sup></div>
    
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="../../index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Inicio</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Referenciales
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Compras</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            
            <a class="collapse-item" href="view.php">Ver / registrar</a>
            <a class="collapse-item" href="../deposito/view.php">Depósito</a>
            <a class="collapse-item" href="../stock/view.php">Stock</a>
            <a class="collapse-item" href="../proveedor/view.php">Proveedor</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Ventas</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="../ventas/view.php">Registrar ventas</a>
            <a class="collapse-item" href="../clientes/view.php">Cliente</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Centro de control
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
    aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Servicios</span>
</a>
<div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="../ciudad/view.php">Ciudad</a>
        <a class="collapse-item" href="../departamento/view.php">Departamento</a>
        <a class="collapse-item" href="../u_medida/view.php">Unidades de Medida</a>
        <a class="collapse-item" href="../producto/view.php">Producto</a>
        <a class="collapse-item" href="../tipo_producto/view.php">Tipo producto</a>
        <div class="collapse-divider"></div>
    </div>
</div>
</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdm"
        aria-expanded="true" aria-controls="collapseAdm">
        <i class="fas fa-fw fa-folder"></i>
        <span>Administración</span>
    </a>
    <div id="collapseAdm" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="usuarios.html">Usuarios</a>
            <a class="collapse-item" href="../reset_password/reset.php">Cambiar contraseña</a>
        </div>
    </div>
</li>


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message >
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div-->

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

        <!-- Topbar Search >
        <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form-->

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS)>
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages>
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts>
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2019</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2019</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li-->

            <!-- Nav Item - Messages>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <!-- Counter - Messages>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                alt="...">
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how
                                would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                alt="...">
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Last month's report looks great, I am very happy with
                                the progress so far, keep up the good work!</div>
                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                told me that people say this to all dogs, even if they aren't good...</div>
                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li-->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                    <img class="img-profile rounded-circle"
                        src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>Message
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Agregar Venta</h1>
                    </div>
                    <?php
                    if (isset($_GET['alert'])) {
                        if ($_GET['alert'] == 1) {
                            echo '<div class="alert alert-danger">Token de sesión Inválido</div>';
                        }
                    }
                    ?>
                    <!-- Formulario -->
                    <form role="form" class="form-horizontal" action="proses.php?act=insert" method="POST"
                        id="form-compras">
                        <div class="box-body">
                            <?php
                            $query_id = mysqli_query($mysqli, "SELECT MAX(cod_venta) as id FROM venta");
                            $data_id = mysqli_fetch_assoc($query_id);
                            $codigo = $data_id['id'] + 1;
                            $fecha = date("Y-m-d");
                            $hora = date("H:i:s");
                            ?>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>"
                                        readonly>
                                </div>
                                <label class="col-sm-1 col-form-label">Fecha</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="fecha" value="<?php echo $fecha; ?>"
                                        readonly>
                                </div>
                                <label class="col-sm-1 col-form-label">Hora</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="hora" value="<?php echo $hora; ?>"
                                        readonly>
                                </div>


                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Número de Factura</label>
                                <div class="col-sm-3">
                                    <?php
                                    // Consultar el último número de factura para mostrarlo
                                    $query_factura = mysqli_query($mysqli, "SELECT MAX(nro_factura) as ultimo FROM venta");
                                    if ($row_factura = mysqli_fetch_assoc($query_factura)) {
                                        $nro_factura = $row_factura['ultimo'] + 1; // Incrementar el último número
                                    } else {
                                        $nro_factura = 1; // Valor inicial si no hay facturas
                                    }
                                    ?>
                                    <input type="text" class="form-control" name="nro_factura"
                                        value="<?php echo $nro_factura; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cliente</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="codigo_cliente" id="codigo_cliente"
                                        required>
                                        <option value=""></option>
                                        <?php
                                        $query_dep = mysqli_query($mysqli, "SELECT id_cliente, cli_nombre, cli_apellido FROM clientes ORDER BY id_cliente ASC");
                                        while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                            echo "<option value=\"$data_dep[id_cliente]\">$data_dep[id_cliente] | $data_dep[cli_nombre] | $data_dep[cli_apellido]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Producto</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" id="codigo_producto">
                                        <option value=""></option>
                                        <?php
                                        $query_dep = mysqli_query($mysqli, "SELECT cod_producto, p_descrip, precio FROM producto ORDER BY cod_producto ASC");
                                        while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                            echo "<option value=\"{$data_dep['cod_producto']}\" data-precio=\"{$data_dep['precio']}\">{$data_dep['cod_producto']} | {$data_dep['p_descrip']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="col-sm-1 col-form-label">Cantidad</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="cantidad_producto" min="1">
                                </div>
                                <button type="button" class="btn btn-primary" id="btn-agregar">Agregar</button>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Depósito</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="codigo_deposito" id="codigo_deposito"
                                        required>
                                        <option value=""></option>
                                        <?php
                                        $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY cod_deposito ASC");
                                        while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                            echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            

                            <table class="table table-bordered" id="tabla-productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <input type="hidden" name="productos" id="productos">
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Guardar">
                                <a href="?module=compras" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

    <script>
        const productos = [];
        const tablaProductos = document.getElementById('tabla-productos').querySelector('tbody');

        document.getElementById('btn-agregar').addEventListener('click', function () {
            const codigoProducto = document.getElementById('codigo_producto');
            const cantidadProducto = document.getElementById('cantidad_producto').value;

            if (codigoProducto.value && cantidadProducto) {
                const precio = parseFloat(codigoProducto.options[codigoProducto.selectedIndex].dataset.precio);
                const total = precio * cantidadProducto;

                productos.push({
                    codigo: codigoProducto.value,
                    cantidad: cantidadProducto,
                    precio: precio
                });

                const row = `
                    <tr>
                        <td>${codigoProducto.options[codigoProducto.selectedIndex].text}</td>
                        <td>${cantidadProducto}</td>
                        <td>${precio.toFixed(2)}</td>
                        <td>${total.toFixed(2)}</td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>
                    </tr>`;
                tablaProductos.innerHTML += row;
                document.getElementById('productos').value = JSON.stringify(productos);

                codigoProducto.value = '';
                document.getElementById('cantidad_producto').value = '';
            }
        });

        tablaProductos.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-eliminar')) {
                const row = event.target.closest('tr');
                const index = Array.from(tablaProductos.children).indexOf(row);
                productos.splice(index, 1);
                row.remove();
                document.getElementById('productos').value = JSON.stringify(productos);
            }
        });

        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>

</html>