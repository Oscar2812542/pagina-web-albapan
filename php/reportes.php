require('fpdf/fpdf186/fpdf.php');
include("conexion.php");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Reporte de Inventario',1,1,'C');

$resultado = mysqli_query($conexion, "SELECT * FROM productos");

while($row = mysqli_fetch_assoc($resultado)){
    $pdf->Cell(0,10,$row['nombre']." - ".$row['cantidad'],1,1);
}

$pdf->Output('D', 'reporte.pdf');
