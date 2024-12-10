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

        // Agregar empleado
        if ($action == 'insert' && isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre_empleado'];
            $apellido = $_POST['ape_empleado'];
            $ci = $_POST['nro_ci_empleado'];
            $mail = $_POST['mail_empleado'];
            $tel = $_POST['tel_empleado'];
            $direccion = $_POST['direc_empleado'];

            // Manejo del archivo cargado (CV)
            if (isset($_FILES['cv_empleado']) && $_FILES['cv_empleado']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['cv_empleado']['tmp_name'];
                $fileName = $_FILES['cv_empleado']['name'];
                $fileSize = $_FILES['cv_empleado']['size'];
                $fileType = $_FILES['cv_empleado']['type'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Validar que sea un archivo PDF
                if ($fileExtension === 'pdf') {
                    $uploadFileDir = __DIR__ . '/CV/'; // Ruta relativa a proses.php

                    // Asegurarse de que el directorio exista
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }

                    // Definir la ruta completa del archivo
                    $destPath = $uploadFileDir . $codigo . $nombre . $apellido . '_cv.' . $fileExtension;

                    // Intentar mover el archivo
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // Insertar datos en la base de datos
                        $queryEmpleados = mysqli_query($mysqli, "INSERT INTO empleados (id_empleado, nombre, apellido, documento, email, telefono, direccion, fecha_ingreso, estado, cvempleado) 
                        VALUES ('$codigo', '$nombre','$apellido','$ci','$mail', '$tel', '$direccion', now(), 'MANDATORY_CHANGE', '$destPath')") 
                                or die('Error: ' . mysqli_error($mysqli));

                        // Insertar usuario asociado
                        $queryObtenerId = mysqli_query($mysqli, "SELECT MAX(id_user) as id FROM usuarios") or die('Error ' . mysqli_error($mysqli));
                        $data_id = mysqli_fetch_assoc($queryObtenerId);
                        $codigouser = $data_id['id'] + 1;

                        $queryUSER = mysqli_query($mysqli, "INSERT INTO usuarios (id_user, username, name_user, password, email, telefono, foto, permisos_acceso, status, idempleado)
                        VALUES('$codigouser', '$mail', CONCAT('$nombre', ' ', '$apellido'), null, '$mail', '$tel', null, 'employee', 'MANDATORY_CHANGE', '$codigo')")
                        or die('Error: ' . mysqli_error($mysqli));

                        $queryCV = mysqli_query($mysqli, "INSERT INTO curriculum (id_curriculum, id_empleado, archivo_cv, fecha_carga)
                        VALUES('$codigo','$codigo', '$destPath', now())") //insert en la tabla curriculum para el registro
                        or die('Error: ' . mysqli_error($mysqli)); //doble value de codigo para que coincida el idcurriculum con el idempleado

                        // Redirigir con un mensaje de éxito
                        if ($queryEmpleados && $queryUSER && $queryCV) {
                            header("Location: view.php?true");
                        } else {
                            header("Location: view.php?fail");
                        }
                    } else {
                        echo "Error al mover el archivo al directorio de destino.";
                    }
                } else {
                    echo "Por favor, cargue un archivo PDF válido.";
                }
            } else {
                echo "Error al cargar el archivo. Por favor, intente nuevamente.";
            }
        }

        // Otros casos (update, delete) se mantienen igual
        // Actualizar depósito
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
