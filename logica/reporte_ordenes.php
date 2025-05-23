<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$estatus = $conexion->real_escape_string($_POST['estatus'] ?? '');

$sql = "SELECT ot.id_orden, c.nombre AS cliente, m.modelo, s.nombre_servicio, ot.fecha_servicio, ot.estatus
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE 1";

if (!empty($desde)) $sql .= " AND ot.fecha_servicio >= '$desde'";
if (!empty($hasta)) $sql .= " AND ot.fecha_servicio <= '$hasta'";
if (!empty($estatus)) $sql .= " AND ot.estatus = '$estatus'";

$res = $conexion->query($sql);

function obtenerNombreEstatus($e) {
  switch ($e) {
    case '1':
      return 'Pendiente';
    case '2':
      return 'Cancelada';
    case '3':
      return 'Terminado';
    default:
      return 'Desconocido';
  }
}

echo "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Cliente</th><th>Motocicleta</th><th>Servicio</th><th>Fecha</th><th>Estatus</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_orden']}</td>
  <td>{$row['cliente']}</td>
  <td>{$row['modelo']}</td>
  <td>{$row['nombre_servicio']}</td>
  <td>{$row['fecha_servicio']}</td>
  <td>" . obtenerNombreEstatus($row['estatus']) . "</td>
  </tr>";
}
echo "</tbody></table>";
?>
