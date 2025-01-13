<?php
session_start();
require "../../../../config/database.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ciempleado = $_POST['ci_asis'];
    $resumen = $_POST['resum'];
    $cantextra = $_POST['horasextra'];
    $fecha = $_POST['fecha'];
    $hora = date('H:i:s', strtotime($fechaHora));

    // Verificar si el CI existe en la tabla empleados
    $check_ci = mysqli_query($mysqli, "SELECT id_empleado FROM empleados WHERE documento = '$ciempleado'");

    if (mysqli_num_rows($check_ci) > 0) {
        // Si el CI existe, obtener el id_empleado correspondiente
        $row = mysqli_fetch_assoc($check_ci);
        $idEmpleado = $row['id_empleado'];
    }

    // Detectar si es Entrada o Salida
    if (isset($_POST['guardarEntrada'])) {
        $queryCheck2 = mysqli_query($mysqli, "SELECT * FROM empleados WHERE documento = '$ciempleado'");
        if (mysqli_num_rows($queryCheck2) > 0) {
            // Verificar si ya existe una entrada para el día
            $queryCheck = mysqli_query($mysqli, "SELECT * FROM horas_extra WHERE (id_empleado = $idEmpleado) AND fecha = '$fecha'");
            if (mysqli_num_rows($queryCheck) == 0) {
                // Registrar entrada
                $query = mysqli_query($mysqli, "INSERT INTO horas_extra (id_empleado, fecha, canthoras, resumen, estado) 
                VALUES ($idEmpleado, '$fecha', '$cantextra', '$resumen', 'Pendiente')")
                    or die('Error: ' . mysqli_error($mysqli));

                // Actualizar legajo
                if ($query) {
                    //actualizarLegajo($mysqli, $idEmpleado, $fecha);
                    header("Location: view.php?alert=successEntrada");
                }
            } else {
                header("Location: view.php?alert=errorDuplicatedEntrada");
            }
        } else {
            header("Location: view.php?alert=NotAnEmployee");
        }
    }
    function actualizarLegajo($mysqli, $idEmpleado, $fecha)
{
    // Obtener el mes y año del registro
    $mes = date('Y-m', strtotime($fecha));

    // Obtener asistencias válidas del mes
    $queryAsistencia = mysqli_query($mysqli, "
        SELECT COUNT(DISTINCT fecha) AS dias_trabajados 
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND hora_entrada IS NOT NULL 
        AND hora_salida IS NOT NULL 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes'
    ");
    $resultAsistencia = mysqli_fetch_assoc($queryAsistencia);
    $diasTrabajados = $resultAsistencia['dias_trabajados'] ?? 0;

    // Calcular ausencias (días sin asistencia ni permisos)
    $queryDiasMes = mysqli_query($mysqli, "SELECT DAY(LAST_DAY('$fecha')) AS total_dias");
    $totalDias = mysqli_fetch_assoc($queryDiasMes)['total_dias'];

    $queryPermisos = mysqli_query($mysqli, "
        SELECT COUNT(*) AS permisos 
        FROM permisos 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'
    ");
    $resultPermisos = mysqli_fetch_assoc($queryPermisos);
    $permisos = $resultPermisos['permisos'] ?? 0;

    $ausencias = $totalDias - $diasTrabajados - $permisos;

    // Calcular horas extras
    $queryHorasExtras = mysqli_query($mysqli, "
        SELECT SUM(canthoras) AS horas_extras 
        FROM horas_extra 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes'
    ");
    $resultHorasExtras = mysqli_fetch_assoc($queryHorasExtras);
    $horasExtras = $resultHorasExtras['horas_extras'] ?? 0;

    // Actualizar o insertar el registro del legajo
    $queryLegajo = mysqli_query($mysqli, "
        SELECT * FROM legajo 
        WHERE id_empleado = $idEmpleado 
        AND mes = '$mes'
    ");
    if (mysqli_num_rows($queryLegajo) > 0) {
        // Actualizar
        mysqli_query($mysqli, "
            UPDATE legajo 
            SET dias_trabajados = $diasTrabajados, 
                permisos = $permisos, 
                ausencias = $ausencias, 
                horas_extras = $horasExtras 
            WHERE id_empleado = $idEmpleado 
            AND mes = '$mes'
        ") or die('Error: ' . mysqli_error($mysqli));
    } else {
        // Insertar
        mysqli_query($mysqli, "
            INSERT INTO legajo (id_empleado, mes, dias_trabajados, permisos, ausencias, horas_extras) 
            VALUES ($idEmpleado, '$mes', $diasTrabajados, $permisos, $ausencias, $horasExtras)
        ") or die('Error: ' . mysqli_error($mysqli));
    }
}

}
