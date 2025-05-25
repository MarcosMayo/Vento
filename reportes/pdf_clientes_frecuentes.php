<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

date_default_timezone_set('Etc/GMT+6');
$hoy = date('Y-m-d');

class PDF extends FPDF {
    function Header() {
        global $hoy;
        $this->Image('../imagenes/image.png', 10, 8, 30); // Logo si tienes
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Clientes más frecuentes – $hoy"),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

// Encabezados
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(20,8,'ID',1,0,'C',true);
$pdf->Cell(100,8,'Cliente',1,0,'C',true);
$pdf->Cell(50,8,'Total de compras',1,1,'C',true);

// Consulta
$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(v.id_venta) AS total_compras
        FROM clientes c
        LEFT JOIN ventas v ON c.id_cliente = v.id_cliente
        GROUP BY c.id_cliente
        ORDER BY total_compras DESC
        LIMIT 20";

$res = $conexion->query($sql);
$pdf->SetFont('Arial','',10);

while ($row = $res->fetch_assoc()) {
    $nombre = utf8_decode($row['nombre'] . ' ' . $row['apellido_paterno']);

    $pdf->Cell(20,8,$row['id_cliente'],1,0,'C');
    $pdf->Cell(100,8,$nombre,1);
    $pdf->Cell(50,8,$row['total_compras'],1,1,'C');
}

$pdf->Output("I", "clientes_frecuentes_$hoy.pdf");
