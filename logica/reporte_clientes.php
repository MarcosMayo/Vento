<?php
include("../logica/conexion.php");

$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(v.id_venta) AS ventas
        FROM clientes c
        LEFT JOIN ventas v ON c.id_cliente = v.id_cliente
        GROUP BY c.id_cliente
        ORDER BY ventas DESC
        LIMIT 20";

$res = $conexion->query($sql);
echo "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Cliente</th><th>Total Compras</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_cliente']}</td>
  <td>{$row['nombre']} {$row['apellido_paterno']}</td>
  <td>{$row['ventas']}</td>
  </tr>";
}
echo "</tbody></table>";
?>
