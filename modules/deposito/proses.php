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
            //$departamento = $_POST['departamento'];
            $descripcion = $_POST['descrip_deposito'];

            // Insertar en la base de datos
            $query = mysqli_query($mysqli, "INSERT INTO deposito (cod_deposito, descrip) VALUES ('$codigo', '$descripcion')") 
                    or die('Error: ' . mysqli_error($mysqli));

            // Redirigir con un mensaje de éxito o error
            if ($query) {
                echo 'llegue 3';
                header("Location: view.php?true");
            } else {
                echo 'llegue 4';
                header("Location: view.php?fail");
            }
        }

        // Actualizar deposito
        elseif ($action == 'update' && isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            //$departamento = $_POST['departamento'];
            $descripcion = $_POST['descrip'];

            // Actualizar en la base de datos
            $query = mysqli_query($mysqli, "UPDATE deposito 
                                            SET descrip='$descripcion'
                                            WHERE cod_deposito='$codigo'") 
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
            $query = mysqli_query($mysqli, "DELETE FROM deposito WHERE cod_deposito='$codigo'") 
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