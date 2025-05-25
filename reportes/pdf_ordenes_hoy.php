<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

date_default_timezone_set('Etc/GMT+6');
$hoy = date('Y-m-d');

class PDF extends FPDF {
    function Header() {
        global $hoy;
        $this->Image('../imagenes/image.png', 10, 8, 30); // ajusta si usas logo
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Órdenes Pendientes del $hoy"),0,1,'C');
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
$pdf->Cell(20,8,'# Orden',1,0,'C',true);
$pdf->Cell(60,8,'Cliente',1,0,'C',true);
$pdf->Cell(50,8,'Motocicleta',1,0,'C',true);
$pdf->Cell(60,8,'Servicio',1,1,'C',true);

// Datos
$sql = "SELECT ot.id_orden, c.nombre, c.apellido_paterno, m.modelo, s.nombre_servicio
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE ot.estatus = 1 AND ot.fecha_servicio = '$hoy'
        ORDER BY ot.hora ASC";

$res = $conexion->query($sql);
$pdf->SetFont('Arial','',10);

if ($res->num_rows === 0) {
    $pdf->Cell(0,8,"No hay órdenes pendientes para hoy.",0,1,'C');
} else {
    while ($row = $res->fetch_assoc()) {
        $cliente = $row['nombre'] . ' ' . $row['apellido_paterno'];
        $pdf->Cell(20,8,$row['id_orden'],1);
        $pdf->Cell(60,8,utf8_decode($cliente),1);
        $pdf->Cell(50,8,utf8_decode($row['modelo']),1);
        $pdf->Cell(60,8,utf8_decode($row['nombre_servicio']),1);
        $pdf->Ln();
    }
}

$pdf->Output("I", "ordenes_pendientes_$hoy.pdf");
