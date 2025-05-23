<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$pagina = intval($_POST['pagina'] ?? 1);
$por_pagina = 5;
$offset = ($pagina - 1) * $por_pagina;

$where = "1";
if (!empty($desde)) $where .= " AND v.fecha_venta >= '$desde'";
if (!empty($hasta)) $where .= " AND v.fecha_venta <= '$hasta'";

// Total de ventas en rango
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM ventas v WHERE $where");
$totalVentas = $totalRes->fetch_assoc()['total'];
$totalPaginas = ceil($totalVentas / $por_pagina);

$sql = "SELECT v.id_venta, v.fecha_venta, v.hora, v.total, v.id_orden, c.nombre, c.apellido_paterno
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE $where
        ORDER BY v.fecha_venta DESC, v.hora DESC
        LIMIT $offset, $por_pagina";

$res = $conexion->query($sql);

echo "<h5 class='mb-3'>Ventas entre $desde y $hasta</h5>";

if ($res->num_rows === 0) {
  echo "<div class='alert alert-warning'>No hay ventas registradas en este rango.</div>";
  return;
}

while ($venta = $res->fetch_assoc()) {
  $cliente = $venta['nombre'] . " " . $venta['apellido_paterno'];
  $tipo = is_null($venta['id_orden']) ? 'Venta Directa' : 'Por Orden';

  echo "<div class='card mb-3'>
    <div class='card-header bg-light'>
      <strong>Venta #{$venta['id_venta']}</strong> | $tipo | $cliente | {$venta['fecha_venta']} {$venta['hora']} | Total: <strong>$" . number_format($venta['total'], 2) . "</strong>
    </div>
    <div class='card-body p-0'>
      <table class='table table-sm table-striped m-0'>
        <thead class='table-light'>
          <tr><th>Refacción</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>
        </thead>
        <tbody>";

  $id_venta = $venta['id_venta'];
  $detalles = $conexion->query("
    SELECT r.nombre_refaccion, dv.cantidad, dv.precio_unitario
    FROM detalle_venta dv
    INNER JOIN refacciones r ON dv.id_refaccion = r.id_refaccion
    WHERE dv.id_venta = $id_venta
  ");

  while ($d = $detalles->fetch_assoc()) {
    $subtotal = $d['cantidad'] * $d['precio_unitario'];
    echo "<tr>
      <td>{$d['nombre_refaccion']}</td>
      <td>{$d['cantidad']}</td>
      <td>$" . number_format($d['precio_unitario'], 2) . "</td>
      <td>$" . number_format($subtotal, 2) . "</td>
    </tr>";
  }

  echo "</tbody></table></div></div>";
}

// Paginación
echo "<nav><ul class='pagination justify-content-center'>";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? 'active' : '';
  echo "<li class='page-item $activo'>
          <button class='page-link' onclick='cargarVentasPorFecha($i)'>$i</button>
        </li>";
}
echo "</ul></nav>";
