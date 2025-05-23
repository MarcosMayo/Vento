<?php
include("../logica/conexion.php");

header("Content-Type: text/html; charset=utf-8");

$sql = "SELECT s.id_servicio, s.nombre_servicio, s.mano_obra, s.precio, COUNT(ot.id_orden) AS veces_usado
        FROM servicios s
        LEFT JOIN orden_trabajo ot ON s.id_servicio = ot.id_servicio
        GROUP BY s.id_servicio
        ORDER BY veces_usado DESC";

$res = $conexion->query($sql);

echo "<h2>Servicios más solicitados</h2>
<table border='1' cellpadding='6' cellspacing='0'>
<tr>
<th>Servicio</th><th>Solicitudes</th><th>Mano de Obra</th><th>Precio Total</th><th>Refacciones</th>
</tr>";

while ($row = $res->fetch_assoc()) {
  $id_servicio = $row['id_servicio'];

  // Obtener refacciones del servicio
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
  $refText = implode(', ', $refacciones);

  echo "<tr>
    <td>{$row['nombre_servicio']}</td>
    <td>{$row['veces_usado']}</td>
    <td>$" . number_format($row['mano_obra'], 2) . "</td>
    <td>$" . number_format($row['precio'], 2) . "</td>
    <td>{$refText}</td>
  </tr>";
}
echo "</table>";
