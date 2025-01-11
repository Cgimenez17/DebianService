<?php
require '../../../vendor/autoload.php'; // Ruta correcta según tu instalación de Composer
use Dompdf\Dompdf;

function generarContrato($datosEmpleado, $clausulasSeleccionadas, $codigoEmpleado)
{
    // Construir el contenido dinámico del contrato
    $contenidoContrato = "
        <h1 style='text-align: center;'>Contrato de Trabajo</h1>
        <p><strong>Nombre del Empleado:</strong> {$datosEmpleado['nombre']} {$datosEmpleado['apellido']}</p>
        <p><strong>Cédula:</strong> {$datosEmpleado['ci']}</p>
        <p><strong>Correo Electrónico:</strong> {$datosEmpleado['correo']}</p>
        <p><strong>Teléfono:</strong> {$datosEmpleado['telefono']}</p>
        <p><strong>Dirección:</strong> {$datosEmpleado['direccion']}</p>
        <hr>
        <h2>Cláusulas Seleccionadas:</h2>
    ";

    foreach ($clausulasSeleccionadas as $clausula) {
        $contenidoContrato .= "<p>- $clausula</p>";
    }

    // Agregar fecha de generación
    $fechaActual = date('d-m-Y');
    $contenidoContrato .= "<hr><p><strong>Fecha de Generación:</strong> $fechaActual</p>";

    // Configurar Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($contenidoContrato);
    $dompdf->setPaper('A4', 'portrait'); // Tamaño de papel y orientación
    // Generar PDF
    try {
        $dompdf->render();
    } catch (Exception $e) {
        echo "Error al generar el PDF: " . $e->getMessage();
        return; // Detener ejecución si hay un error
    }


    // Ruta para guardar el archivo
    $directorioContratos = __DIR__ . '/contratos/';
    if (!is_dir($directorioContratos)) {
        mkdir($directorioContratos, 0777, true);
    }

    $rutaArchivo = $directorioContratos . $codigoEmpleado . '_contrato.pdf';

    // Normalizar la ruta (reemplaza \ y // con / para evitar problemas)
    $rutaArchivo = str_replace(['\\', '//'], '/', $rutaArchivo);

    // Guardar el PDF en el servidor
    file_put_contents($rutaArchivo, $dompdf->output());

    // Retornar la ruta del archivo guardado
    return $rutaArchivo;
}
