<?php
header('Content-Type: application/json');
include("../logica/conexion.php");

$pagina = intval($_POST['pagina'] ?? 1);
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Total registros únicos cliente-moto
$totalRes = $conexion->query("SELECT COUNT(*) AS total FROM motocicletas")->fetch_assoc()['total'];
$totalPaginas = ceil($totalRes / $limite);

// Consulta paginada
$sql = "SELECT c.nombre, c.apellido_paterno, m.marca, m.modelo, m.anio
        FROM motocicletas m
        INNER JOIN clientes c ON m.id_cliente = c.id_cliente
        ORDER BY c.nombre ASC
        LIMIT $offset, $limite";

$res = $conexion->query($sql);

// Construir tabla
$tabla = "<table class='table table-bordered table-striped'>
<thead><tr><th>Cliente</th><th>Marca</th><th>Modelo</th><th>Año</th></tr></thead><tbody>";

while ($row = $res->fetch_assoc()) {
  $nombre = $row['nombre'] . " " . $row['apellido_paterno'];
  $tabla .= "<tr>
    <td>$nombre</td>
    <td>{$row['marca']}</td>
    <td>{$row['modelo']}</td>
    <td>{$row['anio']}</td>
  </tr>";
}
$tabla .= "</tbody></table>";

// Paginación
$paginacion = "";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = $i == $pagina ? "btn-primary" : "btn-outline-secondary";
  $paginacion .= "<button class='btn $activo btn-sm mx-1' onclick='cargarClientesMotos($i)'>$i</button>";
}

echo json_encode([
  "tabla" => $tabla,
  "paginacion" => $paginacion
]);
