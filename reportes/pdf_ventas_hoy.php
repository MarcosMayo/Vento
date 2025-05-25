<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

$hoy = date('Y-m-d');

class PDF extends FPDF {
    function Header() {
        global $hoy;
        $this->Image('../imagenes/image.png', 10, 8, 30); // Ajusta la ruta si es necesario
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,utf8_decode("Reporte de Ventas del día $hoy"),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);

$sql = "SELECT v.id_venta, v.fecha_venta, v.hora, v.total, v.id_orden, c.nombre, c.apellido_paterno
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE v.fecha_venta = '$hoy'
        ORDER BY v.hora DESC";

$res = $conexion->query($sql);

while ($venta = $res->fetch_assoc()) {
    $cliente = $venta['nombre'] . " " . $venta['apellido_paterno'];
    $tipo = is_null($venta['id_orden']) ? 'Venta Directa' : 'Por Orden';

    $pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(0,8,"Venta #{$venta['id_venta']} | $tipo | $cliente | {$venta['hora']}", 0, 1, 'L', true);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,"Total: $" . number_format($venta['total'], 2), 0, 1);
    $pdf->Ln(1);

    // Tabla encabezado
    $pdf->SetFont('Arial','B',9);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(70,7,"Refacción / Mano de Obra",1,0,'C',true);
    $pdf->Cell(30,7,"Cantidad",1,0,'C',true);
    $pdf->Cell(30,7,"Precio",1,0,'C',true);
    $pdf->Cell(30,7,"Subtotal",1,1,'C',true);

    // Refacciones
    $detalles = $conexion->query("
        SELECT r.nombre_refaccion, dv.cantidad, dv.precio_unitario
        FROM detalle_venta dv
        INNER JOIN refacciones r ON dv.id_refaccion = r.id_refaccion
        WHERE dv.id_venta = {$venta['id_venta']}
    ");

    $pdf->SetFont('Arial','',9);
    while ($d = $detalles->fetch_assoc()) {
        $sub = $d['cantidad'] * $d['precio_unitario'];
        $pdf->Cell(70,6,utf8_decode($d['nombre_refaccion']),1);
        $pdf->Cell(30,6,$d['cantidad'],1,0,'C');
        $pdf->Cell(30,6,'$' . number_format($d['precio_unitario'],2),1,0,'C');
        $pdf->Cell(30,6,'$' . number_format($sub,2),1,1,'C');
    }

    // Mano de obra (si es venta por orden)
    if (!is_null($venta['id_orden'])) {
        $res_mano = $conexion->query("
            SELECT s.nombre_servicio, s.mano_obra
            FROM orden_trabajo ot
            INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
            WHERE ot.id_orden = {$venta['id_orden']}
            LIMIT 1
        ");
        if ($res_mano && $mano = $res_mano->fetch_assoc()) {
            $pdf->Cell(70,6,utf8_decode('Mano de obra - ' . $mano['nombre_servicio']),1);
            $pdf->Cell(30,6,'1',1,0,'C');
            $pdf->Cell(30,6,'$' . number_format($mano['mano_obra'],2),1,0,'C');
            $pdf->Cell(30,6,'$' . number_format($mano['mano_obra'],2),1,1,'C');
        }
    }

    $pdf->Ln(4);
}

$pdf->Output("I", "ventas_$hoy.pdf");
