<?php
include("../logica/conexion.php");

$pagina = intval($_POST['pagina'] ?? 1);
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Total de registros
$totalRes = $conexion->query("SELECT COUNT(DISTINCT c.id_cliente) AS total
  FROM clientes c
  LEFT JOIN ventas v ON c.id_cliente = v.id_cliente")->fetch_assoc()['total'];
$totalPaginas = ceil($totalRes / $limite);

// Consulta paginada
$sql = "SELECT c.id_cliente, c.nombre, c.apellido_paterno, COUNT(v.id_venta) AS total_compras
        FROM clientes c
        LEFT JOIN ventas v ON c.id_cliente = v.id_cliente
        GROUP BY c.id_cliente
        ORDER BY total_compras DESC
        LIMIT $offset, $limite";

$res = $conexion->query($sql);

// Construir tabla HTML
$tabla = "<table class='table table-striped table-bordered'>
<thead><tr><th>ID</th><th>Cliente</th><th>Total Compras</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  $nombre = $row['nombre'] . ' ' . $row['apellido_paterno'];
  $tabla .= "<tr>
    <td>{$row['id_cliente']}</td>
    <td>$nombre</td>
    <td>{$row['total_compras']}</td>
  </tr>";
}

$tabla .= "</tbody></table>";

// Generar botones de paginación
$paginacion = "";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? 'btn-primary' : 'btn-outline-secondary';
  $paginacion .= "<button class='btn $activo btn-sm mx-1' onclick='cargarClientesFrecuentes($i)'>$i</button>";
}

echo json_encode([
  "tabla" => $tabla,
  "paginacion" => $paginacion
]);
