<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

date_default_timezone_set('Etc/GMT+6');
$hoy = date('Y-m-d');

class PDF extends FPDF {
    function Header() {
        global $hoy;
        $this->Image('../imagenes/image.png', 10, 8, 30); // si tienes un logo
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Servicios más solicitados – $hoy"),0,1,'C');
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
$pdf->Cell(60,8,'Servicio',1,0,'C',true);
$pdf->Cell(25,8,'Solicitudes',1,0,'C',true);
$pdf->Cell(30,8,'Mano de Obra',1,0,'C',true);
$pdf->Cell(30,8,'Precio Total',1,0,'C',true);
$pdf->Cell(120,8,'Refacciones',1,1,'C',true);

// Datos
$sql = "SELECT s.id_servicio, s.nombre_servicio, s.mano_obra, s.precio, COUNT(ot.id_orden) AS veces_usado
        FROM servicios s
        LEFT JOIN orden_trabajo ot ON s.id_servicio = ot.id_servicio
        GROUP BY s.id_servicio
        ORDER BY veces_usado DESC";

$res = $conexion->query($sql);
$pdf->SetFont('Arial','',9);

while ($row = $res->fetch_assoc()) {
    $id_servicio = $row['id_servicio'];

    // Obtener refacciones asociadas
    $refQuery = $conexion->query("
        SELECT r.nombre_refaccion 
        FROM detalle_servicio ds
        INNER JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
        WHERE ds.id_servicio = $id_servicio
    ");
    $refacciones = [];
    while ($ref = $refQuery->fetch_assoc()) {
        $refacciones[] = $ref['nombre_refaccion'];
    }
    $refText = utf8_decode(implode(', ', $refacciones));

    $pdf->Cell(60,8,utf8_decode($row['nombre_servicio']),1);
    $pdf->Cell(25,8,$row['veces_usado'],1,0,'C');
    $pdf->Cell(30,8,'$' . number_format($row['mano_obra'], 2),1,0,'C');
    $pdf->Cell(30,8,'$' . number_format($row['precio'], 2),1,0,'C');
    $pdf->Cell(120,8,$refText,1,1);
}

$pdf->Output("I", "servicios_solicitados_$hoy.pdf");
