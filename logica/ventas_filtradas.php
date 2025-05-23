<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$cliente = $conexion->real_escape_string($_POST['cliente'] ?? '');

$sql = "SELECT v.id_venta, v.fecha_venta, c.nombre, c.apellido_paterno, v.total 
        FROM ventas v 
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente 
        WHERE 1";

if (!empty($desde)) $sql .= " AND v.fecha_venta >= '$desde'";
if (!empty($hasta)) $sql .= " AND v.fecha_venta <= '$hasta'";
if (!empty($cliente)) {
  $sql .= " AND (c.nombre LIKE '%$cliente%' OR c.apellido_paterno LIKE '%$cliente%')";
}

$sql .= " ORDER BY v.fecha_venta DESC";

$res = $conexion->query($sql);
echo "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Fecha</th><th>Cliente</th><th>Total</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_venta']}</td>
  <td>{$row['fecha_venta']}</td>
  <td>{$row['nombre']} {$row['apellido_paterno']}</td>
  <td>$" . number_format($row['total'], 2) . "</td>
  </tr>";
}
echo "</tbody></table>";
?>
