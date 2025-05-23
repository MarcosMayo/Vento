<?php
include("../logica/conexion.php");

header("Content-Type: text/html; charset=utf-8");

$sql = "SELECT c.nombre, c.apellido_paterno, m.marca, m.modelo, m.anio
        FROM motocicletas m
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        ORDER BY c.nombre ASC";

$res = $conexion->query($sql);

echo "<h2>Clientes con motocicletas</h2>
<table border='1' cellpadding='6' cellspacing='0'>
<tr><th>Cliente</th><th>Marca</th><th>Modelo</th><th>Año</th></tr>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
    <td>{$row['nombre']} {$row['apellido_paterno']}</td>
    <td>{$row['marca']}</td>
    <td>{$row['modelo']}</td>
    <td>{$row['anio']}</td>
  </tr>";
}
echo "</table>";
