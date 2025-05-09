<?php
// Mostrar errores para depuración (opcional en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
require '../logica/conexion.php'; // Asegúrate de que esta ruta esté bien

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y sanitizar los datos
    $id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : 0;
    $marca = isset($_POST['marca']) ? trim($_POST['marca']) : '';
    $modelo = isset($_POST['modelo']) ? trim($_POST['modelo']) : '';
    $anio = isset($_POST['anio']) ? intval($_POST['anio']) : 0;
    $numero_serie = isset($_POST['numero_serie']) ? trim($_POST['numero_serie']) : '';
    $fecha_registro = isset($_POST['fecha_registro']) ? $_POST['fecha_registro'] : ''; // input del form

    // Validar que no haya campos vacíos
    if ($id_cliente && $marca && $modelo && $anio && $numero_serie && $fecha_registro) {
       
        

        // Preparar y ejecutar consulta
        $sql = "INSERT INTO motocicletas (id_cliente, marca, modelo, anio, numero_serie, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "isssss", $id_cliente, $marca, $modelo, $anio, $numero_serie, $fecha_registro);

            if (mysqli_stmt_execute($stmt)) {
                $response = [
                    'success' => true,
                    'message' => 'Motocicleta guardada correctamente.'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error al ejecutar la consulta: ' . mysqli_error($conexion)
                ];
            }

            mysqli_stmt_close($stmt);
        } else {
            $response = [
                'success' => false,
                'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Método no permitido.'
    ];
}

// Respuesta JSON
header('Content-Type: application/json');
echo json_encode($response);
