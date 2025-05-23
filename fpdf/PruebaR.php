<?php

require('./fpdf.php');

class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      $this->Image('logo.png', 185, 5, 20); // Logo
      $this->SetFont('Arial', 'B', 19); 
      $this->Cell(45); // Mover a la derecha
      $this->SetTextColor(0, 0, 0); 
      $this->Cell(110, 15, utf8_decode('Estética Juliz'), 1, 1, 'C', 0);
      $this->Ln(10);

      $this->SetTextColor(228, 100, 0); 
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(0, 10, utf8_decode('Reporte de Ventas por Mes y Semana'), 0, 1, 'C', 0);
      $this->Ln(5);

      /* Campos de la tabla */
      $this->SetFillColor(228, 100, 0); 
      $this->SetTextColor(255, 255, 255); 
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('ID Venta'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('ID Cliente'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('Fecha'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Hora'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Total'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); 
      $this->SetFont('Arial', 'I', 8); 
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
      $this->SetY(-15); 
      $this->SetFont('Arial', 'I', 8); 
      $hoy = date('d/m/Y');
      $this->Cell(0, 10, utf8_decode('Fecha: ' . $hoy), 0, 0, 'R');
   }
}

include '../../Estructura/conexion.php';

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(163, 163, 163);

// Agrupar por mes y semana
$consulta_reporte_venta = $conexion->query("
    SELECT 
        YEAR(fecha) AS año,
        MONTH(fecha) AS mes,
        WEEK(fecha) AS semana,
        id_venta, 
        id_cliente, 
        fecha, 
        hora, 
        total
    FROM venta
    ORDER BY año, mes, semana
");

$i = 1;
$total_general = 0; // Variable para acumular el total general

$ventas_por_mes = [];

while ($datos_reporte = $consulta_reporte_venta->fetch_object()) {
    // Agrupar por mes
    $ventas_por_mes[$datos_reporte->año][$datos_reporte->mes][$datos_reporte->semana][] = $datos_reporte;
}

// Imprimir ventas por mes y semana
foreach ($ventas_por_mes as $año => $meses) {
    foreach ($meses as $mes => $semanas) {
        // Mostrar título del mes
        $nombre_mes = date("F", mktime(0, 0, 0, $mes, 10)); // Obtiene el nombre del mes
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "Ventas del mes: " . utf8_decode($nombre_mes) . " " . $año, 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);

        $total_mes = 0;

        // Imprimir ventas por semana
        foreach ($semanas as $semana => $ventas) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, "Semana " . $semana, 0, 1, 'L');
            
            $pdf->SetFont('Arial', '', 11);
            $total_semana = 0;
            $i = 1;

            foreach ($ventas as $venta) {
                $pdf->Cell(10, 10, utf8_decode($i), 1, 0, 'C', 0);
                $pdf->Cell(25, 10, utf8_decode($venta->id_venta), 1, 0, 'C', 0);
                $pdf->Cell(30, 10, utf8_decode($venta->id_cliente), 1, 0, 'C', 0);
                $pdf->Cell(35, 10, utf8_decode($venta->fecha), 1, 0, 'C', 0);
                $pdf->Cell(30, 10, utf8_decode($venta->hora), 1, 0, 'C', 0);
                $pdf->Cell(30, 10, utf8_decode('$' . $venta->total), 1, 1, 'C', 0);

                $total_semana += $venta->total;
                $i++;
            }

            // Total de ventas por semana
            $pdf->Cell(170, 10, utf8_decode('Total Semana ' . $semana), 1, 0, 'C', 1);
            $pdf->Cell(30, 10, utf8_decode('$' . number_format($total_semana, 2)), 1, 1, 'C', 0);

            $total_mes += $total_semana; // Acumular el total del mes
            $pdf->Ln(5); // Espacio entre semanas
        }

        // Total de ventas del mes
        $pdf->Cell(170, 10, utf8_decode('Total del mes de ' . $nombre_mes . ' ' . $año), 1, 0, 'C', 1);
        $pdf->Cell(30, 10, utf8_decode('$' . number_format($total_mes, 2)), 1, 1, 'C', 0);
        $pdf->Ln(10); // Espacio entre meses
    }
}

$pdf->Output('Reporte_Ventas_Mensual.pdf', 'I');
?>
