<?php
include("../logica/conexion.php");

header("Content-Type: text/html; charset=utf-8");

$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(v.id_venta) AS total_compras
        FROM clientes c
        LEFT JOIN ventas v ON c.id_cliente = v.id_cliente
        GROUP BY c.id_cliente
        ORDER BY total_compras DESC
        LIMIT 20";

$res = $conexion->query($sql);

echo "<h2>Clientes más frecuentes</h2>
<table border='1' cellpadding='6' cellspacing='0'>
<tr><th>ID</th><th>Nombre</th><th>Total de compras</th></tr>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id_cliente']}</td>
    <td>{$row['nombre']} {$row['apellido_paterno']}</td>
    <td>{$row['total_compras']}</td>
  </tr>";
}

echo "</table>";
