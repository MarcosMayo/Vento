<?php
include("../logica/conexion.php");

$por_pagina = 5;
$pagina = intval($_GET['pagina'] ?? 1);
$offset = ($pagina - 1) * $por_pagina;

$hoy = date('Y-m-d');

// Contar total de ventas hoy
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM ventas WHERE fecha_venta = '$hoy'");
$totalVentas = $totalRes->fetch_assoc()['total'];
$totalPaginas = ceil($totalVentas / $por_pagina);

$sql = "SELECT v.id_venta, v.fecha_venta, v.hora, v.total, v.id_orden, c.nombre, c.apellido_paterno
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE v.fecha_venta = '$hoy'
        ORDER BY v.hora DESC
        LIMIT $offset, $por_pagina";

$res = $conexion->query($sql);

echo "<h5 class='mb-3'>Ventas realizadas el $hoy</h5>";

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

// Mostrar mano de obra si es venta por orden
if (!is_null($venta['id_orden'])) {
  $resMano = $conexion->query("
    SELECT s.nombre_servicio, s.mano_obra
    FROM orden_trabajo ot
    INNER JOIN servicios s ON ot.id_servicio = s.id_servicio
    WHERE ot.id_orden = {$venta['id_orden']}
    LIMIT 1
  ");
  if ($resMano && $mano = $resMano->fetch_assoc()) {
    echo "<tr>
      <td><em>Mano de obra - {$mano['nombre_servicio']}</em></td>
      <td>1</td>
      <td>$" . number_format($mano['mano_obra'], 2) . "</td>
      <td>$" . number_format($mano['mano_obra'], 2) . "</td>
    </tr>";
  }
}


  echo "</tbody></table></div></div>";
}

// Mostrar paginación
echo "<nav><ul class='pagination justify-content-center'>";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? 'active' : '';
  echo "<li class='page-item $activo'><button class='page-link' onclick='cargarVentasHoy($i)'>$i</button></li>";
}
echo "</ul></nav>";
