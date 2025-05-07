<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ("conexion.php");

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT id_cliente, nombre, apellido_paterno, apellido_materno 
        FROM clientes 
        WHERE nombre LIKE ? OR apellido_paterno LIKE ? OR apellido_materno LIKE ?
        LIMIT 10";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$like = "%$q%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<table class="table table-hover">';
    echo '<thead><tr><th>Nombre</th><th>Acción</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $nombreCompleto = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
        echo "<tr>
                <td>" . htmlspecialchars($nombreCompleto) . "</td>
                <td><button class='btn btn-success btn-sm' onclick='seleccionarCliente({$row['id_cliente']}, " . json_encode($nombreCompleto) . ")'>Seleccionar</button></td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p class="text-muted">No se encontraron clientes.</p>';
}
?>
