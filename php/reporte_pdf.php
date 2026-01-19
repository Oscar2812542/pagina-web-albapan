<?php
require('fpdf/fpdf186/fpdf.php');
include("conexion.php");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Reporte de Inventario - Panaderia',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,'Producto',1);
$pdf->Cell(30,8,'Cantidad',1);
$pdf->Cell(40,8,'Caducidad',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$resultado = mysqli_query($conexion, "SELECT * FROM productos");

while($row = mysqli_fetch_assoc($resultado)){
    $pdf->Cell(60,8,$row['nombre'],1);
    $pdf->Cell(30,8,$row['cantidad'],1);
    $pdf->Cell(40,8,$row['fecha_caducidad'],1);
    $pdf->Ln();
}

$pdf->Output();
?>
