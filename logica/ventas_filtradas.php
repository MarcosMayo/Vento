<?php
include("../logica/conexion.php");

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$cliente = $conexion->real_escape_string($_POST['cliente'] ?? '');

$sql = "SELECT v.id_venta, v.fecha_venta, v.total,
               c.nombre, c.apellido_paterno
        FROM ventas v
        JOIN clientes c ON v.id_cliente = c.id_cliente
        WHERE 1";

if ($desde) $sql .= " AND v.fecha_venta >= '$desde'";
if ($hasta) $sql .= " AND v.fecha_venta <= '$hasta'";
if ($cliente) $sql .= " AND (c.nombre LIKE '%$cliente%' OR c.apellido_paterno LIKE '%$cliente%')";

$sql .= " ORDER BY v.fecha_venta DESC";

$res = $conexion->query($sql);
?>

<table class="table table-bordered table-sm">
  <thead class="table-light">
    <tr>
      <th>Folio</th>
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Total</th>
      <th>Ticket</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id_venta'] ?></td>
        <td><?= $row['fecha_venta'] ?></td>
        <td><?= $row['nombre'] . ' ' . $row['apellido_paterno'] ?></td>
        <td>$<?= number_format($row['total'], 2) ?></td>
        <td><a href="../vistas/ticket.php?id=<?= $row['id_venta'] ?>" target="_blank" class="btn btn-outline-secondary btn-sm">Ver</a></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
