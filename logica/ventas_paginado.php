<?php
include("../logica/conexion.php");

$pagina = intval($_POST['pagina'] ?? 1);
$limite = 10;
$offset = ($pagina - 1) * $limite;

$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$busqueda = $conexion->real_escape_string($_POST['busqueda'] ?? '');

$where = "WHERE 1";

if (!empty($desde)) $where .= " AND v.fecha >= '$desde'";
if (!empty($hasta)) $where .= " AND v.fecha <= '$hasta'";
if (!empty($busqueda)) {
  $where .= " AND (c.nombre LIKE '%$busqueda%' OR c.apellido_paterno LIKE '%$busqueda%')";
}

// Total de resultados
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM ventas v 
INNER JOIN clientes c ON v.id_cliente = c.id_cliente $where")->fetch_assoc()['total'];
$totalPaginas = ceil($totalRes / $limite);

// Consulta paginada
$sql = "SELECT v.id_venta, v.fecha, c.nombre, c.apellido_paterno, v.total 
        FROM ventas v 
        INNER JOIN clientes c ON v.id_cliente = c.id_cliente 
        $where
        ORDER BY v.fecha DESC 
        LIMIT $offset, $limite";

$res = $conexion->query($sql);

// Construir tabla
$tabla = "<table class='table table-bordered'><thead><tr>
<th>ID</th><th>Fecha</th><th>Cliente</th><th>Total</th></tr></thead><tbody>";
while ($row = $res->fetch_assoc()) {
  $tabla .= "<tr>
  <td>{$row['id_venta']}</td>
  <td>{$row['fecha']}</td>
  <td>{$row['nombre']} {$row['apellido_paterno']}</td>
  <td>$" . number_format($row['total'], 2) . "</td>
  </tr>";
}
$tabla .= "</tbody></table>";

// Paginación
$paginacion = "";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? "btn-primary" : "btn-outline-secondary";
  $paginacion .= "<button class='btn $activo btn-sm mx-1' onclick='cargarVentas($i)'>$i</button>";
}

// Respuesta JSON
echo json_encode([
  "tabla" => $tabla,
  "paginacion" => $paginacion
]);
