<?php 
// Verificar si existe el parámetro 'form' en la URL
if (isset($_GET['form_umedida']) && $_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-plus-circle"></i> Agregar Departamento
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Departamento</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=insert" method="POST">
                    <?php
                    require "../../config/database.php";
                    // Generar el código automáticamente
                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_departamento) as id FROM departamento") or die('Error ' . mysqli_error($mysqli));
                    $count = mysqli_num_rows($query_id);  
                    if ($count <> 0) {
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1;
                    } else {
                        $codigo = 1;
                    }
                    ?>
                    <div class="form-group">
                        <label for="id_departamento">Código</label>
                        <input type="text" class="form-control" id="id_departamento" name="id_departamento" value="<?php echo $codigo; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dep_descripcion">Descripción del departamento</label>
                        <input type="text" class="form-control" id="dep_descripcion" name="dep_descripcion" placeholder="Ingrese descripcion del departamento " required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                    <a href="view.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
<?php
} elseif (isset($_GET['form_umedida']) && $_GET['form'] == 'edit') { 
    if (isset($_GET['id'])) {
        // Consultar los datos de la ciudad
        $query = mysqli_query($mysqli, "SELECT * FROM departamento where id_departamento = '$_GET[id]'") or die('Error: ' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);
    }
    ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-edit"></i> Modificar departamento
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Departamento</a></li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=update" method="POST">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" id="id_departamento" name="id_departamento" value="<?php echo $data['id_departamento']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dep_descripcion">Descripción</label>
                        <input type="text" class="form-control" id="dep_descripcion" name="dep_descripcion" value="<?php echo $data['dep_descripcion']; ?>" required>
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
