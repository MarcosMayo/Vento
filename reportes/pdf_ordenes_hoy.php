<?php
include("../logica/conexion.php");
$hoy = date('Y-m-d');

$sql = "SELECT ot.id_orden, c.nombre, c.apellido_paterno, m.modelo, s.nombre_servicio
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE ot.estatus = 1 AND ot.fecha_servicio = '$hoy'
        ORDER BY ot.hora ASC";

$res = $conexion->query($sql);

echo "<h2>Órdenes pendientes de hoy</h2><table border='1' cellpadding='6'><tr>
<th>ID</th><th>Cliente</th><th>Motocicleta</th><th>Servicio</th></tr>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id_orden']}</td>
    <td>{$row['nombre']} {$row['apellido_paterno']}</td>
    <td>{$row['modelo']}</td>
    <td>{$row['nombre_servicio']}</td>
  </tr>";
}
echo "</table>";
