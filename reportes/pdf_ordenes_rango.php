<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

date_default_timezone_set('Etc/GMT+6');

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$estatus = $_GET['estatus'] ?? '';
if (empty($desde) && empty($hasta)) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,utf8_decode("No se puede generar el reporte sin un rango de fechas."),0,1,'C');
    $pdf->Output();
    exit;
}

$where = "1";
if (!empty($desde)) $where .= " AND ot.fecha_servicio >= '$desde'";
if (!empty($hasta)) $where .= " AND ot.fecha_servicio <= '$hasta'";
if (!empty($estatus)) $where .= " AND ot.estatus = " . intval($estatus);

function nombreEstatus($e) {
  switch (intval($e)) {
    case 1: return 'Pendiente';
    case 2: return 'Cancelada';
    case 3: return 'Completada';
    default: return 'Desconocido';
  }
}

class PDF extends FPDF {
    function Header() {
        global $desde, $hasta;
        $this->Image('../imagenes/image.png', 10, 8, 30); // Logo si lo tienes
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Órdenes de trabajo del $desde al $hasta"),0,1,'C');
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
$pdf->Cell(15,8,'#',1,0,'C',true);
$pdf->Cell(25,8,'Fecha',1,0,'C',true);
$pdf->Cell(45,8,'Cliente',1,0,'C',true);
$pdf->Cell(35,8,'Motocicleta',1,0,'C',true);
$pdf->Cell(45,8,'Servicio',1,0,'C',true);
$pdf->Cell(30,8,'Estatus',1,1,'C',true);

// Datos
$sql = "SELECT ot.id_orden, ot.fecha_servicio, c.nombre, c.apellido_paterno,
               m.modelo, s.nombre_servicio, ot.estatus
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE $where
        ORDER BY ot.fecha_servicio DESC";

$res = $conexion->query($sql);
$pdf->SetFont('Arial','',10);

if ($res->num_rows === 0) {
    $pdf->Cell(0,8,"No hay órdenes registradas en este rango.",0,1,'C');
} else {
    while ($row = $res->fetch_assoc()) {
        $cliente = $row['nombre'] . ' ' . $row['apellido_paterno'];
        $estatusTexto = nombreEstatus($row['estatus']);

        $pdf->Cell(15,8,$row['id_orden'],1);
        $pdf->Cell(25,8,$row['fecha_servicio'],1);
        $pdf->Cell(45,8,utf8_decode($cliente),1);
        $pdf->Cell(35,8,utf8_decode($row['modelo']),1);
        $pdf->Cell(45,8,utf8_decode($row['nombre_servicio']),1);
        $pdf->Cell(30,8,$estatusTexto,1);
        $pdf->Ln();
    }
}

$pdf->Output("I", "ordenes_rango_{$desde}_{$hasta}.pdf");
