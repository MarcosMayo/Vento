<?php
require '../logica/conexion.php'; // Asegúrate que tengas conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = $conexion->query("DELETE FROM usuarios WHERE id_usu = '$id'");

    if ($sql) {
        echo "<script>
                alert('¡Registro eliminado correctamente!');
                window.location.href = '../vistas/usuarios.php'; // Redirige de vuelta a usuarios
              </script>";
    } else {
        echo "<script>
                alert('¡Ocurrió un error al eliminar!');
                window.location.href = '../vistas/usuarios.php';
              </script>";
    }
}
?>
