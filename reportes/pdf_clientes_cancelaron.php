<?php
include("../logica/conexion.php");

header("Content-Type: text/html; charset=utf-8");

$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(ot.id_orden) AS canceladas
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        WHERE ot.estatus = 3
        GROUP BY c.id_cliente
        ORDER BY canceladas DESC";

$res = $conexion->query($sql);

echo "<h2>Clientes que cancelaron órdenes</h2>
<table border='1' cellpadding='6' cellspacing='0'>
<tr><th>ID</th><th>Cliente</th><th>Órdenes Canceladas</th></tr>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id_cliente']}</td>
    <td>{$row['nombre']} {$row['apellido_paterno']}</td>
    <td>{$row['canceladas']}</td>
  </tr>";
}
echo "</table>";
