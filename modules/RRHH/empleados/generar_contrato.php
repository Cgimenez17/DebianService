<?php
require '../../../vendor/autoload.php'; 
use Dompdf\Dompdf;

function generarContrato($datosEmpleado, $clausulasSeleccionadas, $codigoEmpleado)
{
    $contenidoContrato = "
        <h1 style='text-align: center;'>Contrato de Trabajo</h1>
        <p><strong>Nombre del Empleado:</strong> {$datosEmpleado['nombre']} {$datosEmpleado['apellido']}</p>
        <p><strong>Cédula:</strong> {$datosEmpleado['ci']}</p>
        <p><strong>Correo Electrónico:</strong> {$datosEmpleado['correo']}</p>
        <p><strong>Teléfono:</strong> {$datosEmpleado['telefono']}</p>
        <p><strong>Dirección:</strong> {$datosEmpleado['direccion']}</p>
        <p><strong>Cargo:</strong> {$datosEmpleado['cargo']}</p>
        <p><strong>Salario:</strong> {$datosEmpleado['salario']}</p>
        <hr>
        <h2>Cláusulas del contrato:</h2>
    ";

    foreach ($clausulasSeleccionadas as $clausula) {
        // Reemplazar variables dinámicas en la cláusula
        $clausulaProcesada = str_replace(
            ['$salario', '$nombre', '$fechaInicio', '$fechafincontrato'], // Variables
            [$datosEmpleado['salario'], $datosEmpleado['nombre'], $datosEmpleado['fecha_ingreso'], $datosEmpleado['fecha_fin']], // Valores
            $clausula
        );
        $contenidoContrato .= "<p>- $clausulaProcesada</p>";
    }

    $fechaActual = date('d-m-Y');
    $contenidoContrato .= "
        <hr>
        <p><strong>Fecha de generación del Contrato:</strong> $fechaActual</p>
        <br>
        <div style='margin-top: 30px;'>
            <div style='float: left; width: 45%; text-align: center;'>
                <p>___________________________</p>
                <p><strong>Firma del Empleador</strong></p>
            </div>
            <div style='float: right; width: 45%; text-align: center;'>
                <p>___________________________</p>
                <p><strong>Firma del Empleado</strong></p>
            </div>
        </div>
        <div style='clear: both;'></div>
    ";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($contenidoContrato, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');

    try {
        $dompdf->render();
    } catch (Exception $e) {
        echo "Error al generar el PDF: " . $e->getMessage();
        return;
    }

    $directorioContratos = __DIR__ . '/contratos/';
    if (!is_dir($directorioContratos)) {
        mkdir($directorioContratos, 0777, true);
    }

    $rutaArchivo = $directorioContratos . $codigoEmpleado . '_contrato.pdf';
    file_put_contents($rutaArchivo, $dompdf->output());

    return $rutaArchivo;
}


