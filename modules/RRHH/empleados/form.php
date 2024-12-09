<?php 
// Verificar si existe el parámetro 'form' en la URL
if (isset($_GET['form_empleado']) && $_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-plus-circle"></i> Agregar Empleado
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Empleados</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=insert" method="POST">
                    <?php
                    require "../../../config/database.php";
                    // Generar el código automáticamente
                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_empleado) as id FROM empleados") or die('Error ' . mysqli_error($mysqli));
                    $count = mysqli_num_rows($query_id);  
                    if ($count <> 0) {
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1;
                    } else {
                        $codigo = 1;
                    }
                    ?>
                    <div class="form-group">
                        <label for="codigo">Código de Empleado</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nombre_empleado">Nombre</label>
                        <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" placeholder="" required >
                    </div>

                    <div class="form-group">
                        <label for="ape_empleado">Apellido</label>
                        <input type="text" class="form-control" id="ape_empleado" name="ape_empleado" placeholder="" required >
                    </div>

                    <div class="form-group">
                        <label for="nro_ci_empleado">Número de Cédula</label>
                        <input type="text" class="form-control" id="nro_ci_empleado" name="nro_ci_empleado" placeholder="" required >
                    </div>

                    <div class="form-group">
                        <label for="mail_empleado">Correo electrónico</label>
                        <input type="text" class="form-control" id="mail_empleado" name="mail_empleado" placeholder="El correo ingresado se utilizará para el acceso al sistema" required >
                    </div>

                    <div class="form-group">
                        <label for="tel_empleado">Teléfono</label>
                        <input type="text" class="form-control" id="tel_empleado" name="tel_empleado" placeholder="" required >
                    </div>

                    <div class="form-group">
                        <label for="direc_empleado">Dirección</label>
                        <input type="text" class="form-control" id="direc_empleado" name="direc_empleado" placeholder="" required >
                    </div>

                    <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                    <a href="view.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
<?php
} elseif (isset($_GET['form_ciudad']) && $_GET['form'] == 'edit') { 
    if (isset($_GET['id'])) {
        // Consultar los datos de la ciudad
        $query = mysqli_query($mysqli, "select cod_ciudad, descrip_ciudad from ciudad where cod_ciudad = '$_GET[id]'") or die('Error: ' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);
    }
    ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-edit"></i> Modificar Ciudad
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Ciudad</a></li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=update" method="POST">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $data['cod_ciudad']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="descrip">Descripción</label>
                        <input type="text" class="form-control" id="descrip" name="descrip" value="<?php echo $data['descrip_ciudad']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                    <a href="view.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
<?php 
} else { 
    // Si no existe 'form' en la URL o el valor no es válido, redirigir a la lista de ciudades
    header('Location: view.php');
}
?>
