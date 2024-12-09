<?php
session_start();
require "../../../config/database.php"; // Asegúrate de tener la conexión a la base de datos

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
            $nombre = $_POST['nombre_empleado'];
            $apellido = $_POST['ape_empleado'];
            $ci = $_POST['nro_ci_empleado'];
            $mail = $_POST['mail_empleado'];
            $tel = $_POST['tel_empleado'];
            $direccion = $_POST['direc_empleado'];

            $query_id = mysqli_query($mysqli, "SELECT MAX(id_user) as id FROM usuarios") or die('Error ' . mysqli_error($mysqli));
                    $count = mysqli_num_rows($query_id);  
                    if ($count <> 0) {
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigouser = $data_id['id'] + 1;
                    } else {
                        $codigouser = 1;
                    }

            // Insertar en la base de datos
            $query = mysqli_query($mysqli, "INSERT INTO empleados (id_empleado, nombre, apellido, documento, email, telefono, direccion, fecha_ingreso, estado) 
            VALUES ('$codigo', '$nombre','$apellido','$ci','$mail', '$tel', '$direccion' ,now(), 'MANDATORY_CHANGE')") 
                    or die('Error: ' . mysqli_error($mysqli));
                    
            $query2 = mysqli_query($mysqli, "INSERT INTO usuarios (id_user, username, name_user, password, email, telefono, foto, permisos_acceso, status, idempleado)
            VALUES('$codigouser', '$mail','$nombre',null,'$mail', '$tel', null , 'employee', 'MANDATORY_CHANGE', '$codigo')") 
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
            $departamento = $_POST['departamento'];
            $descripcion = $_POST['descrip'];

            // Actualizar en la base de datos
            $query = mysqli_query($mysqli, "UPDATE ciudad 
                                            SET descrip_ciudad='$descripcion'
                                            WHERE cod_ciudad='$codigo'") 
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
            $query = mysqli_query($mysqli, "DELETE FROM ciudad WHERE cod_ciudad='$codigo'") 
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
