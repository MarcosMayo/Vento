<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$empleado = $conexion->real_escape_string($_POST['empleado'] ?? '');

$sql = "SELECT s.id_servicio, s.nombre_servicio, s.descripcion, s.precio, e.nombre AS empleado
        FROM servicios s
        LEFT JOIN orden_trabajo ot ON s.id_servicio = ot.id_servicio
        LEFT JOIN empleados e ON ot.id_empleado = e.id_empleado
        WHERE 1";

if (!empty($desde)) $sql .= " AND ot.fecha_servicio >= '$desde'";
if (!empty($hasta)) $sql .= " AND ot.fecha_servicio <= '$hasta'";
if (!empty($empleado)) {
  $sql .= " AND (e.nombre LIKE '%$empleado%' OR e.apellido_paterno LIKE '%$empleado%')";
}

$res = $conexion->query($sql);
echo "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Servicio</th><th>Descripción</th><th>Empleado</th><th>Precio</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_servicio']}</td>
  <td>{$row['nombre_servicio']}</td>
  <td>{$row['descripcion']}</td>
  <td>{$row['empleado']}</td>
  <td>$" . number_format($row['precio'], 2) . "</td>
  </tr>";
}
echo "</tbody></table>";
?>
