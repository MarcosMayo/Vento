<?php
require('../fpdf/fpdf.php');
include("../logica/conexion.php");

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
if (empty($desde) && empty($hasta)) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,utf8_decode("No se puede generar el reporte sin un rango de fechas."),0,1,'C');
    $pdf->Output();
    exit;
}

$where = "1";
if (!empty($desde)) $where .= " AND v.fecha_venta >= '$desde'";
if (!empty($hasta)) $where .= " AND v.fecha_venta <= '$hasta'";

class PDF extends FPDF {
    function Header() {
        global $desde, $hasta;
        $this->Image('../imagenes/image.png', 10, 8, 30);
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode("Ventas del $desde al $hasta"),0,1,'C');
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
$pdf->SetFont('Arial','',10);

$sql = "SELECT v.id_venta, v.fecha_venta, v.hora, v.total, v.id_orden, c.nombre, c.apellido_paterno
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE $where
        ORDER BY v.fecha_venta DESC, v.hora DESC";

$res = $conexion->query($sql);

$total_general = 0;

if ($res->num_rows === 0) {
    $pdf->Cell(0,10,"No se encontraron ventas en este rango.",0,1);
} else {
    while ($venta = $res->fetch_assoc()) {
        $cliente = $venta['nombre'] . " " . $venta['apellido_paterno'];
        $tipo = is_null($venta['id_orden']) ? 'Venta Directa' : 'Por Orden';

        $pdf->SetFont('Arial','B',11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0,8,"Venta #{$venta['id_venta']} | $tipo | $cliente | {$venta['fecha_venta']} {$venta['hora']}", 0, 1, 'L', true);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,6,"Total: $" . number_format($venta['total'], 2), 0, 1);
        $pdf->Ln(1);

        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(70,7,"Refacción / Mano de Obra",1,0,'C',true);
        $pdf->Cell(30,7,"Cantidad",1,0,'C',true);
        $pdf->Cell(30,7,"Precio",1,0,'C',true);
        $pdf->Cell(30,7,"Subtotal",1,1,'C',true);

        $pdf->SetFont('Arial','',9);
        $total_detalle = 0;

        // Refacciones
        $detalles = $conexion->query("
            SELECT r.nombre_refaccion, dv.cantidad, dv.precio_unitario
            FROM detalle_venta dv
            INNER JOIN refacciones r ON dv.id_refaccion = r.id_refaccion
            WHERE dv.id_venta = {$venta['id_venta']}
        ");
        while ($d = $detalles->fetch_assoc()) {
            $sub = $d['cantidad'] * $d['precio_unitario'];
            $total_detalle += $sub;

            $pdf->Cell(70,6,utf8_decode($d['nombre_refaccion']),1);
            $pdf->Cell(30,6,$d['cantidad'],1,0,'C');
            $pdf->Cell(30,6,'$' . number_format($d['precio_unitario'],2),1,0,'C');
            $pdf->Cell(30,6,'$' . number_format($sub,2),1,1,'C');
        }

        // Mano de obra desde servicios si es venta por orden
        if (!is_null($venta['id_orden'])) {
            $res_mano = $conexion->query("
                SELECT s.mano_obra
                FROM orden_trabajo ot
                INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
                WHERE ot.id_orden = {$venta['id_orden']}
                LIMIT 1
            ");
            if ($res_mano && $mano = $res_mano->fetch_assoc()) {
                $pdf->Cell(70,6,'Mano de obra',1);
                $pdf->Cell(30,6,'1',1,0,'C');
                $pdf->Cell(30,6,'$' . number_format($mano['mano_obra'],2),1,0,'C');
                $pdf->Cell(30,6,'$' . number_format($mano['mano_obra'],2),1,1,'C');
                $total_detalle += $mano['mano_obra'];
            }
        }

        $pdf->Ln(4);
        $total_general += $venta['total'];
    }

    // Total general del reporte
    $pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(220, 250, 220);
    $pdf->Cell(160,8,'Total acumulado del reporte',1,0,'R',true);
    $pdf->Cell(30,8,'$' . number_format($total_general, 2),1,1,'C',true);
}

$pdf->Output("I", "ventas_rango_{$desde}_{$hasta}.pdf");

