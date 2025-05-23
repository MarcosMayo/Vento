<?php
header('Content-Type: application/json');
include("../logica/conexion.php");

$pagina = intval($_POST['pagina'] ?? 1);
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Total servicios usados
$totalRes = $conexion->query("SELECT COUNT(DISTINCT id_servicio) AS total FROM orden_trabajo")->fetch_assoc()['total'];
$totalPaginas = ceil($totalRes / $limite);

// Consulta principal
$sql = "SELECT s.id_servicio, s.nombre_servicio, s.mano_obra, s.precio, COUNT(ot.id_orden) AS veces_usado
        FROM servicios s
        LEFT JOIN orden_trabajo ot ON s.id_servicio = ot.id_servicio
        GROUP BY s.id_servicio
        ORDER BY veces_usado DESC
        LIMIT $offset, $limite";

$res = $conexion->query($sql);

// Tabla HTML
$tabla = "<table class='table table-bordered table-striped'>
<thead>
<tr>
<th>Servicio</th>
<th>Solicitudes</th>
<th>Mano de Obra</th>
<th>Precio Total</th>
<th>Refacciones</th>
</tr>
</thead><tbody>";

while ($row = $res->fetch_assoc()) {
  $id_servicio = $row['id_servicio'];

  // Obtener refacciones asociadas
  $refQuery = $conexion->query("
    SELECT r.nombre_refaccion 
    FROM detalle_servicio ds
    INNER JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
    WHERE ds.id_servicio = $id_servicio
  ");
  $refacciones = [];
  while ($ref = $refQuery->fetch_assoc()) {
    $refacciones[] = $ref['nombre_refaccion'];
  }
  $refText = implode(', ', $refacciones);

  // Agregar fila
  $tabla .= "<tr>
    <td>{$row['nombre_servicio']}</td>
    <td>{$row['veces_usado']}</td>
    <td>$" . number_format($row['mano_obra'], 2) . "</td>
    <td>$" . number_format($row['precio'], 2) . "</td>
    <td>$refText</td>
  </tr>";
}
$tabla .= "</tbody></table>";

// Paginación
$paginacion = "";
for ($i = 1; $i <= $totalPaginas; $i++) {
  $activo = ($i == $pagina) ? "btn-primary" : "btn-outline-secondary";
  $paginacion .= "<button class='btn $activo btn-sm mx-1' onclick='cargarServiciosSolicitados($i)'>$i</button>";
}

// Respuesta JSON
echo json_encode([
  "tabla" => $tabla,
  "paginacion" => $paginacion
]);
