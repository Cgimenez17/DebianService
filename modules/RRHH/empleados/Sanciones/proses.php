<?php
session_start();
require "../../../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciempleado = $_POST['ci_asis'];
    $tipoSancion = $_POST['tipo_sancion'];
    $motivo = $_POST['txt_permiso'];
    $fechaInicio = $_POST['fecha_permiso'];
    $fechaFin = $_POST['fecha_permisofin'];
    $fechaActual = date('Y-m-d');

    $check_ci = mysqli_query($mysqli, "SELECT id_empleado FROM empleados WHERE documento = '$ciempleado'");

    if (mysqli_num_rows($check_ci) > 0) {
        $row = mysqli_fetch_assoc($check_ci);
        $idEmpleado = $row['id_empleado'];

        $queryCheck = mysqli_query($mysqli, "
            SELECT * 
            FROM sancion 
            WHERE id_empleado = $idEmpleado 
            AND fecha_aplicacion BETWEEN '$fechaInicio' AND '$fechaFin'
        ");

        if (mysqli_num_rows($queryCheck) == 0) {
            $query = mysqli_query($mysqli, "
                INSERT INTO sancion (id_empleado, id_tipo_sancion, fecha_aplicacion, descripcion_detalle, fecha_inicio, fecha_fin)
                VALUES ($idEmpleado, $tipoSancion, '$fechaActual', '$motivo', '$fechaInicio', '$fechaFin')
            ") or die('Error: ' . mysqli_error($mysqli));

            if ($query) {
                actualizarLegajo($mysqli, $idEmpleado, $fechaInicio);
                header("Location: view.php?alert=successSancion");
                exit;
            }
        } else {
            header("Location: view.php?alert=errorDuplicatedSancion");
            exit;
        }
    } else {
        header("Location: view.php?alert=NotAnEmployee");
        exit;
    }
} else {
    header("Location: view.php?alert=invalidRequest");
    exit;
}
function actualizarLegajo($mysqli, $idEmpleado, $fecha)
{
    $mes = date('Y-m', strtotime($fecha));

    // Consultar días trabajados
    $queryAsistencia = mysqli_query($mysqli, "
        SELECT COUNT(DISTINCT fecha) AS dias_trabajados 
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND hora_entrada IS NOT NULL 
        AND hora_salida IS NOT NULL 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes'");
    $resultAsistencia = mysqli_fetch_assoc($queryAsistencia);
    $diasTrabajados = $resultAsistencia['dias_trabajados'] ?? 0;

    // Consultar días del mes
    $queryDiasMes = mysqli_query($mysqli, "SELECT DAY(LAST_DAY('$fecha')) AS total_dias");
    $totalDias = mysqli_fetch_assoc($queryDiasMes)['total_dias'];

    // Consultar permisos
    $queryPermisos = mysqli_query($mysqli, "
        SELECT COUNT(*) AS permisos 
        FROM permisos 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'");
    $resultPermisos = mysqli_fetch_assoc($queryPermisos);
    $permisos = $resultPermisos['permisos'] ?? 0;

    // Consultar ausencias
    $ausencias = $totalDias - $diasTrabajados - $permisos;

    // Consultar horas extras
    $queryHorasExtras = mysqli_query($mysqli, "
        SELECT SUM(TIMESTAMPDIFF(HOUR, '08:00:00', hora_salida)) AS horas_extras 
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes' 
        AND hora_salida > '17:00:00'");
    $resultHorasExtras = mysqli_fetch_assoc($queryHorasExtras);
    $horasExtras = $resultHorasExtras['horas_extras'] ?? 0;

    // Consultar sanciones (solo tipos 2 y 4 para Multa o descuento salarial)
    $querySanciones = mysqli_query($mysqli, "
        SELECT SUM(IF(id_tipo_sancion IN (2, 4), 1, 0)) AS sanciones 
        FROM sancion 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'");
    $resultSanciones = mysqli_fetch_assoc($querySanciones);
    $sanciones = $resultSanciones['sanciones'] ?? 0;

    // Ajustar ausencias considerando sanciones
    $ausencias -= $sanciones;

    // Verificar si ya existe el registro en la tabla `legajo`
    $queryLegajo = mysqli_query($mysqli, "SELECT * FROM legajo WHERE id_empleado = $idEmpleado AND mes = '$mes'");
    if (mysqli_num_rows($queryLegajo) > 0) {
        // Actualizar registro existente
        mysqli_query($mysqli, "
            UPDATE legajo 
            SET dias_trabajados = $diasTrabajados, 
                permisos = $permisos, 
                ausencias = $ausencias, 
                horas_extras = $horasExtras 
            WHERE id_empleado = $idEmpleado AND mes = '$mes'")
            or die('Error: ' . mysqli_error($mysqli));
    } else {
        // Insertar nuevo registro
        mysqli_query($mysqli, "
            INSERT INTO legajo (id_empleado, mes, dias_trabajados, permisos, ausencias, horas_extras) 
            VALUES ($idEmpleado, '$mes', $diasTrabajados, $permisos, $ausencias, $horasExtras)")
            or die('Error: ' . mysqli_error($mysqli));
    }
}
?>