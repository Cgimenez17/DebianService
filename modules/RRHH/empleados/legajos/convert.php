<?php
require '../../../../vendor/autoload.php'; 
use Dompdf\Dompdf;
use Dompdf\Options;

require('../../../../config/database.php');

function obtenerDatosLegajo($mysqli, $idEmpleado, $mes) {
    $datos = [];

    // Obtener datos básicos del empleado
    $queryEmpleado = mysqli_query($mysqli, "SELECT * FROM empleados WHERE id_empleado = $idEmpleado");
    $datos['empleado'] = mysqli_fetch_assoc($queryEmpleado);

    // Obtener días trabajados
    $queryAsistencia = mysqli_query($mysqli, "
        SELECT COUNT(DISTINCT fecha) AS dias_trabajados 
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND hora_entrada IS NOT NULL 
        AND hora_salida IS NOT NULL 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes'");
    $datos['asistencia'] = mysqli_fetch_assoc($queryAsistencia);

    // Obtener permisos
    $queryPermisos = mysqli_query($mysqli, "
        SELECT COUNT(*) AS permisos 
        FROM permisos 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'");
    $datos['permisos'] = mysqli_fetch_assoc($queryPermisos);

    // Obtener sanciones
    $querySanciones = mysqli_query($mysqli, "
        SELECT COUNT(*) AS sanciones 
        FROM sancion 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha_inicio, '%Y-%m') = '$mes'");
    $datos['sanciones'] = mysqli_fetch_assoc($querySanciones);

    // Obtener horas extras
    $queryHorasExtras = mysqli_query($mysqli, "
        SELECT SUM(TIMESTAMPDIFF(HOUR, '08:00:00', hora_salida)) AS horas_extras 
        FROM asistencia 
        WHERE id_empleado = $idEmpleado 
        AND DATE_FORMAT(fecha, '%Y-%m') = '$mes' 
        AND hora_salida > '17:00:00'");
    $datos['horas_extras'] = mysqli_fetch_assoc($queryHorasExtras);

    // Obtener ausencias
    $querylegajo = mysqli_query($mysqli, "
        SELECT ausencias 
        FROM legajo 
        WHERE id_empleado = $idEmpleado 
        AND mes = '$mes'");
    $datos['ausencias'] = mysqli_fetch_assoc($querylegajo);

    return $datos;
}


$idEmpleado = $_POST['idEmpleado'];
$mes = $_POST['mes'];

$datosLegajo = obtenerDatosLegajo($mysqli, $idEmpleado, $mes);

// Generar PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true); // Requerido si se usa PHP en el contenido del PDF
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

$html = '
    <h1 style="text-align: center;">Legajo de Empleado</h1>
    <p><strong>Nombre:</strong> ' . $datosLegajo['empleado']['nombre'] . '</p>
    <p><strong>Documento:</strong> ' . $datosLegajo['empleado']['documento'] . '</p>
    <p><strong>Mes:</strong> ' . $mes . '</p>
    <hr>
    <p><strong>Días Trabajados:</strong> ' . $datosLegajo['asistencia']['dias_trabajados'] . '</p>
    <p><strong>Permisos:</strong> ' . $datosLegajo['permisos']['permisos'] . '</p>
    <p><strong>Sanciones:</strong> ' . $datosLegajo['sanciones']['sanciones'] . '</p>
    <p><strong>Horas Extras:</strong> ' . $datosLegajo['horas_extras']['horas_extras'] . '</p>
    <p><strong>Ausencias:</strong> ' . $datosLegajo['ausencias']['ausencias'] . '</p>
';

$dompdf->loadHtml($html);
$dompdf->render();

$pdfContent = $dompdf->output();
$directorioLegajos = __DIR__ . '/legajos/';
if (!is_dir($directorioLegajos)) {
    mkdir($directorioLegajos, 0777, true);
}

$rutaArchivo = $directorioLegajos . $idEmpleado . $mes .'_legajo.pdf';
file_put_contents($rutaArchivo, $pdfContent);

echo $rutaArchivo;

?>
