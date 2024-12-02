<?php
require_once '../../config/database.php';
require_once '../../reporte/reporte_ventas.php';

// Función para convertir caracteres especiales a ISO-8859-1
//function convertir($texto) {
  //  return mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
//}

$pdf = new BasePDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Consulta los datos
$query = "SELECT 
    v.cod_venta,
    CONCAT(c.cli_nombre, ' ', c.cli_apellido) AS cliente, -- Concatenar nombre y apellido
    v.fecha,
    v.total_venta,
    v.estado,
    v.hora,
    v.nro_factura
FROM 
    venta v
JOIN 
    clientes c ON v.id_cliente = c.id_cliente;
";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->SetX(20);
    $pdf->Cell(10, 10, convertir($row['cod_venta']), 1, 0, 'C');
    $pdf->Cell(35, 10, convertir($row['cliente']), 1, 0, 'C');
    $pdf->Cell(25, 10, convertir($row['fecha']), 1, 0, 'C');
    $pdf->Cell(25, 10, convertir($row['total_venta']), 1, 0, 'C');
    $pdf->Cell(20, 10, convertir($row['estado']), 1, 0, 'C');
    $pdf->Cell(27, 10, convertir($row['hora']), 1, 0, 'C'); // Ahora muestra el nombre del depósito
    $pdf->Cell(27, 10, convertir($row['nro_factura']), 1, 1, 'C');

}

// Mostrar el PDF en el navegador
$pdf->Output('I', 'Reporte_Ventas.pdf');
?>
