<?php
include("../logica/conexion.php");

$sql = "SELECT id_refaccion, nombre_refaccion, precio, stock FROM refacciones ORDER BY nombre_refaccion ASC";
$res = $conexion->query($sql);

echo "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
  <td>{$row['id_refaccion']}</td>
  <td>{$row['nombre_refaccion']}</td>
  <td>$" . number_format($row['precio'], 2) . "</td>
  <td>{$row['stock']}</td>
  </tr>";
}
echo "</tbody></table>";
?>
