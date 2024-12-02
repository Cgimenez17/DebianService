<?php 
// Verificar si existe el parámetro 'form' en la URL
if (isset($_GET['form_producto']) && $_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-plus-circle"></i> Agregar Producto
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Producto</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=insert" method="POST">
                    <?php
                    require "../../config/database.php";
                    // Generar el código automáticamente
                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_producto) as id FROM producto") or die('Error ' . mysqli_error($mysqli));
                    $count = mysqli_num_rows($query_id);  
                    if ($count <> 0) {
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1;
                    } else {
                        $codigo = 1;
                    }
                    ?>
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>" readonly>
                    </div>
                <!-- combo box tipo producto -->
                    <div class="form-group">
                        <label for="tproducto">Tipo Producto</label>
                        <select name="tproducto" id="tproducto" class="form-control">
                            <option value="">Seleccione el tipo de producto</option>
                            <?php 
                            $query_dep = mysqli_query($mysqli, "SELECT cod_tipo_prod, t_p_descrip FROM tipo_producto ORDER BY cod_tipo_prod ASC") or die('Error ' . mysqli_error($mysqli));
                            while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                echo "<option value=\"$data_dep[cod_tipo_prod]\">$data_dep[cod_tipo_prod] | $data_dep[t_p_descrip]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- combo box unidad de medida -->
                    <div class="form-group">
                        <label for="umedida">Tipo Producto</label>
                        <select name="umedida" id="umedida" class="form-control">
                            <option value="">Seleccione la unidad de medida</option>
                            <?php 
                            $query_dep = mysqli_query($mysqli, "SELECT id_u_medida, u_descrip FROM u_medida ORDER BY id_u_medida ASC") or die('Error ' . mysqli_error($mysqli));
                            while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                echo "<option value=\"$data_dep[id_u_medida]\">$data_dep[id_u_medida] | $data_dep[u_descrip]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descrip_producto">Descripción Producto</label>
                        <input type="text" class="form-control" id="descrip_producto" name="descrip_producto" placeholder="Ingrese descripcion del Producto " required>
                    </div>

                    <div class="form-group">
                        <label for="descrip_precio">Precio</label>
                        <input type="text" class="form-control" id="descrip_precio" name="descrip_precio" placeholder="Ingrese el precio del Producto " required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                    <a href="view.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
<?php
} elseif (isset($_GET['form_producto']) && $_GET['form'] == 'edit') { 
    if (isset($_GET['id'])) {
        // Consultar los datos del producto
        $query = mysqli_query($mysqli, "SELECT * FROM producto WHERE cod_producto = '$_GET[id]'") 
        or die('Error: ' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);
    }
    ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-edit"></i> Modificar Producto
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Producto</a></li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>

        <div class="card shadow mb-4">
    <div class="card-body">
        <form action="proses.php?act=update" method="POST">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $data['cod_producto']; ?>" readonly>
            </div>

            <!-- Combo box Tipo Producto -->
            <div class="form-group">
                <label for="tproducto">Tipo Producto</label>
                <select name="tproducto" id="tproducto" class="form-control">
                    <option value="">Seleccione el tipo de producto</option>
                    <?php 
                    $query_dep = mysqli_query($mysqli, "SELECT cod_tipo_prod, t_p_descrip FROM tipo_producto ORDER BY cod_tipo_prod ASC") or die('Error ' . mysqli_error($mysqli));
                    while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                        // Compara el valor actual con el valor seleccionado
                        $selected = ($data_dep['cod_tipo_prod'] == $data['cod_tipo_prod']) ? 'selected' : '';
                        echo "<option value=\"$data_dep[cod_tipo_prod]\" $selected>$data_dep[cod_tipo_prod] | $data_dep[t_p_descrip]</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Combo box Unidad de Medida -->
            <div class="form-group">
                <label for="umedida">Unidad de Medida</label>
                <select name="umedida" id="umedida" class="form-control">
                    <option value="">Seleccione la unidad de medida</option>
                    <?php 
                    $query_dep = mysqli_query($mysqli, "SELECT id_u_medida, u_descrip FROM u_medida ORDER BY id_u_medida ASC") or die('Error ' . mysqli_error($mysqli));
                    while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                        // Compara el valor actual con el valor seleccionado
                        $selected = ($data_dep['id_u_medida'] == $data['id_u_medida']) ? 'selected' : '';
                        echo "<option value=\"$data_dep[id_u_medida]\" $selected>$data_dep[id_u_medida] | $data_dep[u_descrip]</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Campo Descripción Producto -->
            <div class="form-group">
                <label for="descrip_producto">Descripción Producto</label>
                <input type="text" class="form-control" id="descrip_producto" name="descrip_producto" value="<?php echo $data['p_descrip']; ?>">
            </div>

            <!-- Campo Precio -->
            <div class="form-group">
                <label for="descrip_precio">Descripción Precio</label>
                <input type="text" class="form-control" id="descrip_precio" name="descrip_precio" value="<?php echo $data['precio']; ?>">
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
