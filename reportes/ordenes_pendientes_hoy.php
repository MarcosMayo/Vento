<?php
include("../logica/conexion.php");

$por_pagina = 5;
$pagina = intval($_GET['pagina'] ?? 1);
$offset = ($pagina - 1) * $por_pagina;

$hoy = date('Y-m-d');

// Contar total de órdenes pendientes hoy
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM orden_trabajo WHERE estatus = 1 AND fecha_servicio = '$hoy'");
$totalOrdenes = $totalRes->fetch_assoc()['total'];
$totalPaginas = ceil($totalOrdenes / $por_pagina);

// Obtener datos con paginación
$sql = "SELECT ot.id_orden, ot.hora, c.nombre, c.apellido_paterno, m.modelo, s.nombre_servicio
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE ot.estatus = 1 AND ot.fecha_servicio = '$hoy'
        ORDER BY ot.hora ASC
        LIMIT $offset, $por_pagina";

$res = $conexion->query($sql);

echo "<h5>Órdenes pendientes del $hoy</h5>";
echo "<table class='table table-bordered table-striped'>
<thead><tr><th>ID</th><th>Hora</th><th>Cliente</th><th>Motocicleta</th><th>Servicio</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id_orden']}</td>
    <td>{$row['hora']}</td>
    <td>{$row['nombre']} {$row['apellido_paterno']}</td>
    <td>{$row['modelo']}</td>
    <td>{$row['nombre_servicio']}</td>
  </tr>";
}
echo "</tbody></table>";

// Paginación
echo "<nav><ul class='pagination justify-content-center'>";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? 'active' : '';
  echo "<li class='page-item $activo'>
          <button class='page-link' onclick='cargarOrdenesHoy($i)'>$i</button>
        </li>";
}
echo "</ul></nav>";

