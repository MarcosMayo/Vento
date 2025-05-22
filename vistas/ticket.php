<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../logica/conexion.php");

// Obtener info de empresa
$sqlEmpresa = "SELECT nombre,telefono, rfc, direccion FROM empresa LIMIT 1";
$resEmpresa = $conexion->query($sqlEmpresa);
$empresa = $resEmpresa ? $resEmpresa->fetch_assoc() : null;

// ID de venta
$id_venta = intval($_GET['id'] ?? 0);

// Consulta venta
$sqlVenta = "SELECT v.id_venta, v.id_orden, v.fecha_venta, v.total,
                    c.nombre, c.apellido_paterno, c.apellido_materno
             FROM ventas v
             JOIN clientes c ON v.id_cliente = c.id_cliente
             WHERE v.id_venta = $id_venta LIMIT 1";
$resVenta = $conexion->query($sqlVenta);

if (!$resVenta) {
    die("Error en la consulta de venta: " . $conexion->error);
}
$venta = $resVenta->fetch_assoc();

// Mano de obra si es venta por orden
$id_orden = intval($venta['id_orden'] ?? 0);
$mano_obra = 0;

if ($id_orden > 0) {
    $sqlManoObra = "SELECT s.mano_obra
                    FROM orden_trabajo ot
                    JOIN servicios s ON ot.id_servicio = s.id_servicio
                    WHERE ot.id_orden = $id_orden";
    $resMano = $conexion->query($sqlManoObra);
    if ($resMano && $filaMano = $resMano->fetch_assoc()) {
        $mano_obra = floatval($filaMano['mano_obra']);
    }
}

// Consulta detalle
$sqlDetalle = "SELECT r.nombre_refaccion, dv.cantidad, dv.precio_unitario
               FROM detalle_venta dv
               JOIN refacciones r ON dv.id_refaccion = r.id_refaccion
               WHERE dv.id_venta = $id_venta";
$detalle = $conexion->query($sqlDetalle);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket de Venta</title>
  <style>
    body { font-family: monospace; padding: 10px; }
    .ticket { width: 80mm; margin: auto; }
    .ticket h2, .ticket p { text-align: center; margin: 5px 0; }
    .linea { border-top: 1px dashed black; margin: 10px 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { font-size: 12px; text-align: left; padding: 2px 0; }
    th { border-bottom: 1px solid black; }
    td:last-child, th:last-child { text-align: right; }
  </style>
</head>
<body onload="window.print()">
  <div class="ticket">
    <?php if ($empresa): ?>
      <h2><?= htmlspecialchars($empresa['nombre']) ?></h2>
      <p>
        <?= htmlspecialchars($empresa['direccion']) ?><br>
        Tel: <?= htmlspecialchars($empresa['telefono']) ?><br>
        RFC: <?= htmlspecialchars($empresa['rfc']) ?>
      </p>
    <?php else: ?>
      <h2>VENTOSCS</h2>
      <p>Empresa no configurada</p>
    <?php endif; ?>

    <div class="linea"></div>

    <p><strong>Folio:</strong> <?= $venta['id_venta'] ?><br>
       <strong>Fecha:</strong> <?= $venta['fecha_venta'] ?><br>
       <strong>Cliente:</strong> <?= $venta['nombre'] . ' ' . $venta['apellido_paterno'] . ' ' . $venta['apellido_materno'] ?></p>
          <strong>Método de pago:</strong> Efectivo</p>


    <div class="linea"></div>

    <table>
      <tr>
        <th>Concepto</th>
        <th>Cant.</th>
        <th>Precio</th>
        <th>Subtotal</th>
      </tr>

      <?php
      $subtotal_refacciones = 0;
      while($row = $detalle->fetch_assoc()):
        $precio_unit = floatval($row['precio_unitario']);
        $sub = $row['cantidad'] * $precio_unit;
        $subtotal_refacciones += $sub;
      ?>
        <tr>
          <td><?= $row['nombre_refaccion'] ?></td>
          <td><?= $row['cantidad'] ?></td>
          <td>$<?= number_format($precio_unit, 2) ?></td>
          <td>$<?= number_format($sub, 2) ?></td>
        </tr>
      <?php endwhile; ?>

      <?php if ($id_orden > 0): ?>
        <tr>
          <td>Mano de obra</td>
          <td>1</td>
          <td>$<?= number_format($mano_obra, 2) ?></td>
          <td>$<?= number_format($mano_obra, 2) ?></td>
        </tr>
      <?php endif; ?>
    </table>

    <div class="linea"></div>
    <p><strong>Total: $<?= number_format($venta['total'], 2) ?></strong></p>
    <div class="linea"></div>
    <p>¡Gracias por su compra!</p>
  </div>
</body>
</html>
