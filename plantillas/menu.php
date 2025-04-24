<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Taller</title>
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="../botstrap/bot.css">
  <link rel="stylesheet" href="../botstrap/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  
</head>
<body>
 
  <!-- Botón hamburguesa en móviles -->
  <nav class="navbar navbar-light bg-primary d-md-none">
    <div class="container-fluid">
      <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
        <i class="bi bi-list fs-3"></i>
      </button>
      <span class="navbar-brand mb-0 h1 text-white">TALLER</span>
    </div>
  </nav>

  <div class="main-wrapper">
    <!-- Menú lateral -->
    <div class="offcanvas-md offcanvas-start bg-primary text-white sidebar" tabindex="-1" id="sidebarMenu">
      <div class="offcanvas-header d-md-none">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body p-3">
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-house-door-fill me-2"></i>Inicio</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-person-badge-fill me-2"></i>Usuarios</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-wrench-adjustable-circle-fill me-2"></i>Orden de trabajo</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-journal-plus me-2"></i>Registrar</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-box-seam-fill me-2"></i>Productos</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-graph-up-arrow me-2"></i>Reportes</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i>Historial</a>
          </li>
          <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white"><i class="bi bi-box-arrow-left me-2"></i>Salir</a>
          </li>
        </ul>
      </div>
    </div>

    

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>