<?php
require_once '../../config/database.php';
require_once '../../reporte/reporte_umedida.php';

$pdf = new BasePDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Consulta los datos
$query = "SELECT * FROM u_medida";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->SetX(70); // Ajusta este valor según el ancho de tu página y tabla

    $pdf->Cell(20, 10, $row['id_u_medida'], 1, 0, 'C');
    $pdf->Cell(70, 10, convertir($row['u_descrip']), 1, 1, 'C');
}

// Mostrar el PDF en el navegador
$pdf->Output('I', 'Reporte_UnidadDeMedida.pdf');
