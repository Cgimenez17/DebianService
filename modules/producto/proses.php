<?php
session_start();
require "../../config/database.php"; // Asegúrate de tener la conexión a la base de datos

// Verificar si el usuario está autenticado
//if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
//    header("Location: ../../index.php?alert=3");
//    exit;
//} else {
    // Detectar la acción
    if (isset($_GET['act'])) {
        $action = $_GET['act'];
        echo (' llegue 1 $action');
        // Agregar deposito
        if ($action == 'insert' && isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $cod_tipo_prod = $_POST['tproducto'];
            $id_u_medida = $_POST['umedida'];
            $p_descrip = $_POST['descrip_producto'];
            $precio = $_POST['descrip_precio'];

            // Insertar en la base de datos
            $query = mysqli_query($mysqli, "INSERT INTO producto (cod_producto, cod_tipo_prod, id_u_medida, p_descrip, precio)
             VALUES ('$codigo', '$cod_tipo_prod', '$id_u_medida', '$p_descrip', '$precio')") 
                    or die('Error: ' . mysqli_error($mysqli));

            // Redirigir con un mensaje de éxito o error
            if ($query) {
                header("Location: view.php?true");
            } else {
                header("Location: view.php?fail");
            }
        }

        // Actualizar deposito
        elseif ($action == 'update' && isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $cod_tipo_prod = $_POST['tproducto'];
            $id_u_medida = $_POST['umedida'];
            $p_descrip = $_POST['descrip_producto'];
            $precio = $_POST['descrip_precio'];

            // Actualizar en la base de datos
            $query = mysqli_query($mysqli, "UPDATE producto 
                                            SET cod_tipo_prod='$cod_tipo_prod',
                                            id_u_medida = '$id_u_medida',
                                            p_descrip = '$p_descrip',
                                            precio = '$precio'
                                            WHERE cod_producto='$codigo'") 
                    or die('Error: ' . mysqli_error($mysqli));

            // Redirigir con un mensaje
            if ($query) {
                header("Location: view.php?true");
            } else {
                header("Location: view.php?fail");
            }
        }

        // Eliminar Ciudad
        elseif ($action == 'delete' && isset($_GET['id'])) {
            $codigo = $_GET['id'];

            // Eliminar de la base de datos
            $query = mysqli_query($mysqli, "DELETE FROM producto WHERE cod_producto='$codigo'") 
                     or die('Error: ' . mysqli_error($mysqli));

            // Redirigir con un mensaje
            if ($query) {
                header("Location: view.php?true");
            } else {
                header("Location: view.php?fail");
            }
        }
    }
//}
?>
