<?php

require('../fpdf/fpdf.php');
include("../logica/conexion.php");

$hoy = date('Y-m-d');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"Ventas del día $hoy", 0,1,'C');
$pdf->Ln(5);

$sql = "SELECT v.id_venta, v.fecha_venta, v.hora, v.total, v.id_orden, c.nombre, c.apellido_paterno
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE v.fecha_venta = '$hoy'
        ORDER BY v.hora DESC";

$res = $conexion->query($sql);

$pdf->SetFont('Arial','',10);

while ($venta = $res->fetch_assoc()) {
    $cliente = $venta['nombre'] . " " . $venta['apellido_paterno'];
    $tipo = is_null($venta['id_orden']) ? 'Venta Directa' : 'Por Orden';
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(0,8,"Venta #{$venta['id_venta']} | $tipo | $cliente | {$venta['hora']} | Total: $" . number_format($venta['total'],2),0,1);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(50,7,"Refacción",1);
    $pdf->Cell(30,7,"Cantidad",1);
    $pdf->Cell(30,7,"Precio",1);
    $pdf->Cell(30,7,"Subtotal",1);
    $pdf->Ln();

    $detalles = $conexion->query("
        SELECT r.nombre_refaccion, dv.cantidad, dv.precio_unitario
        FROM detalle_venta dv
        INNER JOIN refacciones r ON dv.id_refaccion = r.id_refaccion
        WHERE dv.id_venta = {$venta['id_venta']}
    ");

    $pdf->SetFont('Arial','',9);
    while ($d = $detalles->fetch_assoc()) {
        $sub = $d['cantidad'] * $d['precio_unitario'];
        $pdf->Cell(50,6,$d['nombre_refaccion'],1);
        $pdf->Cell(30,6,$d['cantidad'],1);
        $pdf->Cell(30,6,'$' . number_format($d['precio_unitario'],2),1);
        $pdf->Cell(30,6,'$' . number_format($sub,2),1);
        $pdf->Ln();
    }

    $pdf->Ln(4);
}

$pdf->Output("I", "ventas_$hoy.pdf");
