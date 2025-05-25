<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$estatus = $_POST['estatus'] ?? '';
$pagina = intval($_POST['pagina'] ?? 1);
$por_pagina = 5;
$offset = ($pagina - 1) * $por_pagina;

if (empty($desde) && empty($hasta)) {
  echo "<div class='alert alert-warning'>Por favor selecciona al menos una fecha para realizar la búsqueda.</div>";
  return;
}

$where = "1";
if (!empty($desde)) $where .= " AND ot.fecha_servicio >= '$desde'";
if (!empty($hasta)) $where .= " AND ot.fecha_servicio <= '$hasta'";
if (!empty($estatus)) $where .= " AND ot.estatus = " . intval($estatus);

// Total
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM orden_trabajo ot WHERE $where");
$totalOrdenes = $totalRes->fetch_assoc()['total'];
$totalPaginas = ceil($totalOrdenes / $por_pagina);

// Consulta paginada
$sql = "SELECT ot.id_orden, ot.fecha_servicio, c.nombre, c.apellido_paterno,
               m.modelo, s.nombre_servicio, ot.estatus
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
        WHERE $where
        ORDER BY ot.fecha_servicio DESC
        LIMIT $offset, $por_pagina";

$res = $conexion->query($sql);

function nombreEstatus($e) {
  switch (intval($e)) {
    case 1: return 'Pendiente';
    case 2: return 'Cancelada';
    case 3: return 'Completada';
    default: return 'Desconocido';
  }
}

echo "<h5>Órdenes del rango</h5>
<table class='table table-bordered'>
<thead class='table-light'>
<tr>
<th>ID</th><th>Fecha</th><th>Cliente</th><th>Motocicleta</th><th>Servicio</th><th>Estatus</th>
</tr>
</thead><tbody>";

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

echo "</tbody></table>";

// Paginación
echo "<nav><ul class='pagination justify-content-center'>";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? 'active' : '';
  echo "<li class='page-item $activo'>
    <button class='page-link' onclick=\"cargarOrdenesPorFecha($i, '$desde', '$hasta', '$estatus')\">$i</button>
  </li>";
}
echo "</ul></nav>";
