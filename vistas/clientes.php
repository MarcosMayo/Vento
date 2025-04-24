<?php
$clientes = [
    [
        'nombre' => 'María González',
        'apellidos' => 'Pérez López',
        'telefono' => '(555) 123-4567',
        'email' => 'maria@example.com',
        'fecha_registro' => '15/03/2025',
        'folio' => '1'
    ],
   
];

$total_clientes = count($clientes);
$modo_nuevo = isset($_GET['accion']) && $_GET['accion'] === 'nuevo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <link rel="stylesheet" href="botstrap/bot.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-danger-subtle"> 
  <div class="container-fluid p-4">
    <?php if(!$modo_nuevo): ?>
    <!-- Vista de listado de clientes -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h3 mb-0 d-inline-block me-2">
          <i class="bi bi-people-fill text-danger me-2"></i>Clientes
        </h1>
        <span class="badge bg-danger"><?= $total_clientes ?></span>
      </div>
      <a href="?accion=nuevo" class="btn btn-danger text-white">
        <i class="bi bi-person-plus-fill me-2"></i>Nuevo cliente
      </a>
    </div>

    <div class="card shadow-sm bg-body-tertiary">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="bg-danger text-white">
              <tr>
                <th><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                <th><i class="bi bi-person-lines-fill me-2"></i>Apellidos</th>
                <th><i class="bi bi-telephone-fill me-2"></i>Teléfono</th>
                <th><i class="bi bi-envelope-fill me-2"></i>Email</th>
                <th><i class="bi bi-calendar-check me-2"></i>Fecha Registro</th>
                <th><i class="bi bi-file-earmark-text me-2"></i>Folio</th>
                <th><i class="bi bi-gear-fill me-2"></i>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($clientes as $cliente): ?>
              <tr class="bg-light">
                <td><?= $cliente['nombre'] ?></td>
                <td><?= $cliente['apellidos'] ?></td>
                <td><?= $cliente['telefono'] ?></td>
                <td><?= $cliente['email'] ?></td>
                <td><?= $cliente['fecha_registro'] ?></td>
                <td><?= $cliente['folio'] ?></td>
                <td>
                  <a href="#" class="btn btn-sm btn-outline-danger me-1" title="Editar">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-outline-dark" title="Eliminar">
                    <i class="bi bi-trash3-fill"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php else: ?>
    <!-- Vista de nuevo cliente -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 mb-0">
        <i class="bi bi-person-plus-fill text-danger me-2"></i>Nuevo cliente
      </h1>
      <a href="clientes.php" class="btn btn-outline-dark">
        <i class="bi bi-arrow-left-circle-fill me-1"></i>Volver
      </a>
    </div>

    <div class="card shadow-sm bg-body-tertiary">
      <div class="card-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-person-fill me-2"></i>Nombre</label>
              <input type="text" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-person-badge-fill me-2"></i>Apellidos</label>
              <input type="text" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-telephone-fill me-2"></i>Número telefónico</label>
              <input type="tel" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
              <input type="email" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-calendar-date-fill me-2"></i>Fecha de registro</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i>Folio</label>
              <input type="text" class="form-control" required>
            </div>
          </div>

          <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="confirmarDatos">
            <label class="form-check-label" for="confirmarDatos">
              <i class="bi bi-check-circle-fill me-2"></i>Confirmar datos
            </label>
          </div>

          <button type="submit" class="btn btn-danger w-100 py-2">
            <i class="bi bi-check-circle-fill me-2"></i>Continuar
          </button>
        </form>
      </div>
    </div>
    <?php endif; ?>
  </div>

  
</body>
</html>
