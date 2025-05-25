<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

date_default_timezone_set('Etc/GMT+6');
$hoy = date('Y-m-d');

class PDF extends FPDF {
    function Header() {
        global $hoy;
        $this->Image('../imagenes/image.png', 10, 8, 30); // Logo opcional
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Clientes con motocicletas registradas – $hoy"),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF('L'); // Horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

// Encabezados
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(100,8,'Cliente',1,0,'C',true);
$pdf->Cell(50,8,'Marca',1,0,'C',true);
$pdf->Cell(70,8,'Modelo',1,0,'C',true);
$pdf->Cell(30,8,'Año',1,1,'C',true);

// Consulta
$sql = "SELECT c.nombre, c.apellido_paterno, m.marca, m.modelo, m.anio
        FROM motocicletas m
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        ORDER BY c.nombre ASC";

$res = $conexion->query($sql);
$pdf->SetFont('Arial','',10);

while ($row = $res->fetch_assoc()) {
    $cliente = utf8_decode($row['nombre'] . ' ' . $row['apellido_paterno']);
    $marca = utf8_decode($row['marca']);
    $modelo = utf8_decode($row['modelo']);

    $pdf->Cell(100,8,$cliente,1);
    $pdf->Cell(50,8,$marca,1);
    $pdf->Cell(70,8,$modelo,1);
    $pdf->Cell(30,8,$row['anio'],1,1,'C');
}

$pdf->Output("I", "clientes_motocicletas_$hoy.pdf");
