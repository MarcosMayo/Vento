<?php
include("../logica/conexion.php");

$desde = $_GET['desde'] ?? '';
$hasta = $_GET['hasta'] ?? '';
$estatus = $_GET['estatus'] ?? '';

$where = "1";
if (!empty($desde)) $where .= " AND ot.fecha_servicio >= '$desde'";
if (!empty($hasta)) $where .= " AND ot.fecha_servicio <= '$hasta'";
if (!empty($estatus)) $where .= " AND ot.estatus = " . intval($estatus);

$sql = "SELECT ot.id_orden, ot.fecha_servicio, c.nombre, c.apellido_paterno,
               m.modelo, s.nombre_servicio, ot.estatus
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE $where
        ORDER BY ot.fecha_servicio DESC";

$res = $conexion->query($sql);

function nombreEstatus($e) {
  switch (intval($e)) {
    case 1:
      return 'Pendiente';
    case 2:
      return 'Cancelada';
    case 3:
      return 'Completada';
    default:
      return 'Desconocido';
  }
}

echo "<h2>Órdenes de trabajo del rango</h2><table border='1' cellpadding='6'><tr>
<th>ID</th><th>Fecha</th><th>Cliente</th><th>Motocicleta</th><th>Servicio</th><th>Estatus</th></tr>";

while ($row = $res->fetch_assoc()) {
  $cliente = $row['nombre'] . ' ' . $row['apellido_paterno'];
  echo "<tr>
    <td>{$row['id_orden']}</td>
    <td>{$row['fecha_servicio']}</td>
    <td>$cliente</td>
    <td>{$row['modelo']}</td>
    <td>{$row['nombre_servicio']}</td>
    <td>" . nombreEstatus($row['estatus']) . "</td>
  </tr>";
}
echo "</table>";
