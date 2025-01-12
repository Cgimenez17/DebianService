<?php
session_start();
require "../../../../config/database.php";

// Verificar el método de la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciempleado = $_POST['ci_asis'];
    $motivo = $_POST['txt_permiso'];
    $fechaInicio = $_POST['fecha_permiso'];
    $fechaFin = $_POST['fecha_permisofin'];
    $fechaHora = date('Y-m-d');

    $check_ci = mysqli_query($mysqli, "SELECT id_empleado FROM empleados WHERE documento = '$ciempleado'");

    if (mysqli_num_rows($check_ci) > 0) {
        $row = mysqli_fetch_assoc($check_ci);
        $idEmpleado = $row['id_empleado'];

        $queryCheck = mysqli_query($mysqli, "
            SELECT * 
            FROM permisos 
            WHERE id_empleado = $idEmpleado 
            AND fecha_inicio = '$fechaInicio' 
            AND fecha_fin = '$fechaFin'
        ");

        if (mysqli_num_rows($queryCheck) == 0) {
            $query = mysqli_query($mysqli, "
                INSERT INTO permisos (id_empleado, fecha_solicitud, fecha_inicio, fecha_fin, motivo, estado) 
                VALUES ($idEmpleado, '$fechaHora', '$fechaInicio', '$fechaFin', '$motivo', 'Pendiente')
            ") or die('Error: ' . mysqli_error($mysqli));

            if ($query) {
                actualizarLegajo($mysqli, $idEmpleado, $fechaInicio);
                header("Location: view.php?alert=successEntrada");
                exit();
            } else {
                header("Location: view.php?alert=errorDatabase");
                exit();
            }
        } else {
            header("Location: view.php?alert=errorDuplicatedEntrada");
            exit();
        }
    } else {
        header("Location: view.php?alert=NotAnEmployee");
        exit();
    }
}

// Verificar si se reciben parámetros 'act' y 'id' en la URL
if (isset($_GET['act']) && isset($_GET['id'])) {
    $action = $_GET['act'];
    $idPermiso = intval($_GET['id']); // Asegurarse de que sea un número entero

    // Verificar el estado actual del permiso
    $queryState = mysqli_query($mysqli, "SELECT estado FROM permisos WHERE id_permiso = $idPermiso");
    if ($queryState) {
        $row = mysqli_fetch_assoc($queryState);
        $currentState = $row['estado'];

        if ($currentState === 'Aceptado' || $currentState === 'Rechazado') {
            // Si ya está aceptado o rechazado, no permitir actualizar
            header("Location: viewt.php?alert=alreadyProcessed");
            exit();
        }

        // Ejecutar acciones según el valor de 'act'
        if ($action === 'accept') {
            // Actualizar estado a "Aceptado"
            $query = mysqli_query($mysqli, "UPDATE permisos SET estado = 'Aceptado' WHERE id_permiso = $idPermiso")
                or die('Error: ' . mysqli_error($mysqli));
            if ($query) {
                header("Location: viewt.php?alert=successAccepted");
                exit();
            } else {
                header("Location: viewt.php?alert=errorDatabase");
                exit();
            }
        } elseif ($action === 'reject') {
            // Actualizar estado a "Rechazado"
            $query = mysqli_query($mysqli, "UPDATE permisos SET estado = 'Rechazado' WHERE id_permiso = $idPermiso")
                or die('Error: ' . mysqli_error($mysqli));
            if ($query) {
                header("Location: viewt.php?alert=successRejected");
                exit();
            } else {
                header("Location: viewt.php?alert=errorDatabase");
                exit();
            }
        } else {
            header("Location: viewt.php?alert=invalidAction");
            exit();
        }
    } else {
        header("Location: viewt.php?alert=missingPermission");
        exit();
    }
} else {
    header("Location: viewt.php?alert=missingParameters");
    exit();
}
function actualizarLegajo($mysqli, $idEmpleado, $fecha)
{
    $mes = date('Y-m', strtotime($fecha));

    $queryAsistencia = mysqli_query($mysqli, "SELECT COUNT(DISTINCT fecha) AS dias_trabajados FROM asistencia WHERE id_empleado = $idEmpleado AND hora_entrada IS NOT NULL AND hora_salida IS NOT NULL AND DATE_FORMAT(fecha, '%Y-%m') = '$mes'");
    $resultAsistencia = mysqli_fetch_assoc($queryAsistencia);
    $diasTrabajados = $resultAsistencia['dias_trabajados'] ?? 0;

    $queryDiasMes = mysqli_query($mysqli, "SELECT DAY(LAST_DAY('$fecha')) AS total_dias");
    $totalDias = mysqli_fetch_assoc($queryDiasMes)['total_dias'];

    $queryPermisos = mysqli_query($mysqli, "SELECT COUNT(*) AS permisos FROM permisos WHERE id_empleado = $idEmpleado AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'");
    $resultPermisos = mysqli_fetch_assoc($queryPermisos);
    $permisos = $resultPermisos['permisos'] ?? 0;

    $ausencias = $totalDias - $diasTrabajados - $permisos;

    $queryHorasExtras = mysqli_query($mysqli, "
        SELECT SUM(TIMESTAMPDIFF(HOUR, '08:00:00', hora_salida)) AS horas_extras
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes' 
        AND hora_salida > '17:00:00'");
    $resultHorasExtras = mysqli_fetch_assoc($queryHorasExtras);
    $horasExtras = $resultHorasExtras['horas_extras'] ?? 0;

    $queryLegajo = mysqli_query($mysqli, "SELECT * FROM legajo WHERE id_empleado = $idEmpleado AND mes = '$mes'");
    if (mysqli_num_rows($queryLegajo) > 0) {
        mysqli_query($mysqli, "UPDATE legajo SET dias_trabajados = $diasTrabajados, permisos = $permisos, ausencias = $ausencias, horas_extras = $horasExtras WHERE id_empleado = $idEmpleado AND mes = '$mes'")
            or die('Error: ' . mysqli_error($mysqli));
    } else {
        mysqli_query($mysqli, "INSERT INTO legajo (id_empleado, mes, dias_trabajados, permisos, ausencias, horas_extras) VALUES ($idEmpleado, '$mes', $diasTrabajados, $permisos, $ausencias, $horasExtras)")
            or die('Error: ' . mysqli_error($mysqli));
    }
}
?>
?>
