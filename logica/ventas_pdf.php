<?php
include("../logica/conexion.php");

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$busqueda = $conexion->real_escape_string($_GET['busqueda'] ?? '');

$where = "WHERE 1";
if (!empty($desde)) $where .= " AND v.fecha >= '$desde'";
if (!empty($hasta)) $where .= " AND v.fecha <= '$hasta'";
if (!empty($busqueda)) {
  $where .= " AND (c.nombre LIKE '%$busqueda%' OR c.apellido_paterno LIKE '%$busqueda%')";
}

$sql = "SELECT v.id_venta, v.fecha, c.nombre, c.apellido_paterno, v.total 
        FROM ventas v 
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente 
        $where
        ORDER BY v.fecha DESC";

$res = $conexion->query($sql);

// Salida HTML para PDF o impresión
echo "<h3>Reporte de Ventas</h3><table border='1' cellpadding='5' cellspacing='0'><thead><tr>
<th>ID</th><th>Fecha</th><th>Cliente</th><th>Total</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_venta']}</td>
  <td>{$row['fecha']}</td>
  <td>{$row['nombre']} {$row['apellido_paterno']}</td>
  <td>$" . number_format($row['total'], 2) . "</td>
  </tr>";
}
echo "</tbody></table>";
