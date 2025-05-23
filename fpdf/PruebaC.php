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
      $this->Cell(0, 10, utf8_decode('Reporte de Citas por Estado'), 0, 1, 'C', 0);
      $this->Ln(5);
   }

   // Títulos para cada sección
   function SectionTitle($title)
   {
      $this->SetFillColor(228, 100, 0); 
      $this->SetTextColor(255, 255, 255); 
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(0, 10, utf8_decode($title), 0, 1, 'C', 1);
      $this->Ln(5);
   }

   // Encabezado de tabla
   function TableHeader()
   {
      $this->SetFillColor(228, 100, 0); 
      $this->SetTextColor(255, 255, 255); 
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(20, 10, utf8_decode('ID Cita'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('Cliente'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('Servicio'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('Estado'), 1, 1, 'C', 1);
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

// Consultar los diferentes estados disponibles
$consulta_estados = $conexion->query("SELECT id_estado, estatus FROM estado_cita");

while ($estado = $consulta_estados->fetch_object()) {
   // Título de la sección
   $pdf->SectionTitle("Citas " . $estado->estatus);

   // Encabezado de la tabla
   $pdf->TableHeader();
   
   // Consultar citas por cada estado
   $consulta_citas = $conexion->query("
      SELECT 
         c.id_cita,
         cl.nombre AS cliente,
         s.nombre AS servicio,
         e.estatus AS estado
      FROM citas c
      JOIN cliente cl ON c.id_cliente = cl.id_cliente
      JOIN servicios s ON c.id_servicio = s.id_servicio
      JOIN estado_cita e ON c.id_estado = e.id_estado
      WHERE c.id_estado = {$estado->id_estado}
   ");

   if ($consulta_citas->num_rows > 0) {
      while ($datos_cita = $consulta_citas->fetch_object()) {
         $pdf->Cell(20, 10, utf8_decode($datos_cita->id_cita), 1, 0, 'C', 0);
         $pdf->Cell(60, 10, utf8_decode($datos_cita->cliente), 1, 0, 'C', 0);
         $pdf->Cell(60, 10, utf8_decode($datos_cita->servicio), 1, 0, 'C', 0);
         $pdf->Cell(40, 10, utf8_decode($datos_cita->estado), 1, 1, 'C', 0);
      }
   } else {
      $pdf->Cell(0, 10, utf8_decode('No hay citas registradas en este estado.'), 1, 1, 'C', 0);
   }

   $pdf->Ln(5); // Espacio entre secciones
}

// Salida del PDF
$pdf->Output('Reporte_Citas.pdf', 'I');
?>
