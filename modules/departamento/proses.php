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
        // Agregar deposito
        if ($action == 'insert' && isset($_POST['Guardar'])) {
            $codigo = $_POST['id_departamento'];
            $descripcion = $_POST['dep_descripcion'];
            echo 'llegue 2';
            // Insertar en la base de datos
            $query = mysqli_query($mysqli, "INSERT INTO departamento (id_departamento, dep_descripcion) VALUES ('$codigo', '$descripcion')") 
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
            $codigo = $_POST['id_departamento'];
            $descripcion = $_POST['dep_descripcion'];

            // Actualizar en la base de datos
            $query = mysqli_query($mysqli, "update departamento set dep_descripcion = '$descripcion' where id_departamento = '$codigo';") 
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
            $query = mysqli_query($mysqli, "DELETE FROM departamento WHERE id_departamento='$codigo'") 
                     or die('Error: ' . mysqli_error($mysqli));
            echo "DELETE FROM departamento WHERE id_departamento='$codigo'";

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
