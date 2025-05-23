<?php
header('Content-Type: application/json');
include("../logica/conexion.php");

$pagina = intval($_POST['pagina'] ?? 1);
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Total clientes con al menos una orden cancelada (estatus 3)
$totalRes = $conexion->query("
  SELECT COUNT(DISTINCT c.id_cliente) AS total
  FROM orden_trabajo ot
  INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
  INNER JOIN clientes c ON m.id_cliente = c.id_cliente
  WHERE ot.estatus = 3
")->fetch_assoc()['total'];

$totalPaginas = ceil($totalRes / $limite);

// Consulta paginada
$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(ot.id_orden) AS canceladas
        FROM orden_trabajo ot
        INNER JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        WHERE ot.estatus = 3
        GROUP BY c.id_cliente
        ORDER BY canceladas DESC
        LIMIT $offset, $limite";

$res = $conexion->query($sql);

// Tabla
$tabla = "<table class='table table-bordered table-striped'>
<thead><tr><th>ID</th><th>Cliente</th><th>Órdenes Canceladas</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  $nombre = $row['nombre'] . " " . $row['apellido_paterno'];
  $tabla .= "<tr>
    <td>{$row['id_cliente']}</td>
    <td>{$nombre}</td>
    <td>{$row['canceladas']}</td>
  </tr>";
}
$tabla .= "</tbody></table>";

// Paginación
$paginacion = "";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = $i == $pagina ? "btn-primary" : "btn-outline-secondary";
  $paginacion .= "<button class='btn $activo btn-sm mx-1' onclick='cargarClientesCancelaron($i)'>$i</button>";
}

echo json_encode([
  "tabla" => $tabla,
  "paginacion" => $paginacion
]);
