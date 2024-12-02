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
        //echo (' llegue 1 $action');
        // Agregar deposito
        if ($action == 'insert' && isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $razon_social = $_POST['descrip_razon'];
            $ruc = $_POST['descrip_ruc'];
            $direccion = $_POST['descrip_direccion'];
            $telefono = $_POST['descrip_telefono'];

            // Insertar en la base de datos
            $query = mysqli_query($mysqli, "INSERT INTO proveedor (cod_proveedor, razon_social, ruc, direccion, telefono) 
            VALUES ('$codigo', '$razon_social', '$ruc', '$direccion', '$telefono')") 
                    or die('Error: ' . mysqli_error($mysqli));

            // Redirigir con un mensaje de éxito o error
            if ($query) {
                //echo 'llegue 3';
                header("Location: view.php?true");
            } else {
                //echo 'llegue 4';
                header("Location: view.php?fail");
            }
        }

       // Actualizar deposito
       elseif ($action == 'update' && isset($_POST['Guardar'])) {
        $codigo = $_POST['codigo'];
        $razon_social = $_POST['descrip_razon'];
        $ruc = $_POST['descrip_ruc'];
        $direccion = $_POST['descrip_direccion'];
        $telefono = $_POST['descrip_telefono'];
    

    
        // Actualizar en la base de datos
        $query = mysqli_query($mysqli, "UPDATE proveedor 
                                        SET razon_social='$razon_social',
                                            ruc='$ruc',
                                            direccion='$direccion',
                                            telefono='$telefono'
                                        WHERE cod_proveedor='$codigo'")
                or die('Error: ' . mysqli_error($mysqli));
    
        // Redirigir con un mensaje
        if ($query) {
            header("Location: view.php?true");
        } else {
            header("Location: view.php?fail");
        }
        exit;
    }
    

        // Eliminar Ciudad
        elseif ($action == 'delete' && isset($_GET['id'])) {
            $codigo = $_GET['id'];

            // Eliminar de la base de datos
            $query = mysqli_query($mysqli, "DELETE FROM proveedor WHERE cod_proveedor='$codigo'") 
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
