<?php

$motos = [
    [
        'marca' => 'Honda',
        'modelo' => 'CBR 600RR',
        'año' => '2022',
        'historial' => 'Cambio de aceite 03/2023',
        'observaciones' => 'No sirve',
        'folio' => 'MOTO-01'
    ],
    
];

$total_motos = count($motos);
$modo_nuevo = isset($_GET['accion']) && $_GET['accion'] === 'nuevo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motos</title>
    <link rel="stylesheet" href="botstrap/bot.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-danger-subtle"> 
    <div class="container-fluid p-4">
        <?php if(!$modo_nuevo): ?>
        <!-- Vista de listado de motos -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 d-inline-block me-2">
                    <i class="bi bi-bicycle text-primary me-2"></i>Motos
                </h1>
                <span class="badge bg-primary"><?= $total_motos ?></span>
            </div>
            <a href="?accion=nuevo" class="btn btn-primary text-white">
                <i class="bi bi-plus-circle me-2"></i>Nueva moto
            </a>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                    <thead class="bg-primary text-white">
  <tr>
    <th><i class="bi bi-tag me-2"></i>Marca</th>
    <th><i class="bi bi-gear-fill me-2"></i>Modelo</th>
    <th><i class="bi bi-calendar3 me-2"></i>Año</th>
    <th><i class="bi bi-journal-text me-2"></i>Historial</th>
    <th><i class="bi bi-chat-left-dots-fill me-2"></i>Observaciones</th>
    <th><i class="bi bi-file-earmark-text me-2"></i>Folio</th>
    <th><i class="bi bi-wrench-adjustable-circle me-2"></i>Acciones</th>
  </tr>
</thead>

                        <tbody>
                            <?php foreach($motos as $moto): ?>
                            <tr>
                                <td><?= $moto['marca'] ?></td>
                                <td><?= $moto['modelo'] ?></td>
                                <td><?= $moto['año'] ?></td>
                                <td><?= $moto['historial'] ?></td>
                                <td><?= $moto['observaciones'] ?></td>
                                <td><?= $moto['folio'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
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
        <!-- Vista de nueva moto -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle text-primary me-2"></i>Nueva moto
            </h1>
            <a href="motos.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-tag me-2"></i>Marca</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-gear me-2"></i>Modelo</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-calendar me-2"></i>Año</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-file-earmark me-2"></i>Folio</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-file-text me-2"></i>Historial de servicios</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-chat-square-text me-2"></i>Observaciones</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="confirmarDatos">
                        <label class="form-check-label" for="confirmarDatos">
                            <i class="bi bi-check-circle me-2"></i>Confirmar datos
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary text-white w-100 py-2">
                        <i class="bi bi-check-circle me-2"></i>Continuar
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
     
</body>
</html>