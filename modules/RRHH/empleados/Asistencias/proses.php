<?php
session_start();
require "../../../../config/database.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ciempleado = $_POST['ci_asis'];
    $fechaHora = $_POST['fec_ingreso'];
    $fecha = date('Y-m-d', strtotime($fechaHora));
    $hora = date('H:i:s', strtotime($fechaHora));

    // Verificar si el CI existe en la tabla empleados
    $check_ci = mysqli_query($mysqli, "SELECT id_empleado FROM empleados WHERE documento = '$ciempleado'");

    if (mysqli_num_rows($check_ci) > 0) {
        // Si el CI existe, obtener el id_empleado correspondiente
        $row = mysqli_fetch_assoc($check_ci);
        $idEmpleado = $row['id_empleado'];
    } else {
        // Si no existe, registrar el CI en la tabla de asistencias sin id_empleado
        $idEmpleado = 'NULL';
    }

    // Detectar si es Entrada o Salida
    if (isset($_POST['guardarEntrada'])) {
        // Verificar si ya existe un registro sin hora de salida para la misma fecha
        $queryCheck2 = mysqli_query($mysqli, "SELECT * FROM empleados WHERE (documento = '$ciempleado')");
        echo "SELECT * FROM empleados WHERE (documento = '$ciempleado')";
        if (mysqli_num_rows($queryCheck2) > 0) {
            $queryCheck = mysqli_query($mysqli, "SELECT * FROM asistencia WHERE (id_empleado = $idEmpleado OR ci = '$ciempleado') AND fecha = '$fecha' AND hora_salida IS NULL");
            if (mysqli_num_rows($queryCheck) == 0) {
                // Registrar la hora de entrada
                $query = mysqli_query($mysqli, "INSERT INTO asistencia (id_empleado, fecha, hora_entrada, hora_salida ,ci) VALUES ($idEmpleado, '$fecha', '$hora', null, '$ciempleado')")
                    or die('Error: ' . mysqli_error($mysqli));
                if ($query) {
                    header("Location: view.php?alert=successEntrada");
                }
            } else {
                header("Location: view.php?alert=errorDuplicatedEntrada");
            }
        } else {
            header("Location: view.php?alert=NotAnEmployee");
        }
    } elseif (isset($_POST['guardarSalida'])) {
        $check2 = mysqli_query($mysqli, "SELECT * FROM empleados WHERE (documento = '$ciempleado')");
        // Actualizar el registro con la hora de salida
        if (mysqli_num_rows($check2) > 0) {
            $query = mysqli_query($mysqli, "UPDATE asistencia SET hora_salida = '$hora', ci = '$ciempleado' WHERE fecha = '$fecha' AND hora_salida IS NULL")
                or die('Error: ' . mysqli_error($mysqli));
            if ($query && mysqli_affected_rows($mysqli) > 0) {
                header("Location: view.php?alert=successSalida");
            } else {
                header("Location: view.php?alert=errorNoEntrada");
            }
        }else{
            header("Location: view.php?alert=NotAnEmployee");
        }
    }
}
