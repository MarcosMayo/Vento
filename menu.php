<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Taller</title>
  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

  <div class="d-flex flex-column flex-md-row vh-100">
    
    <!-- Barra lateral azul -->
    <nav class="bg-primary text-white p-3 d-flex flex-md-column align-items-start" style="width: 100%; max-width: 240px;">
      <span class="fs-4 mb-4 d-none d-md-block">🏍 Taller</span>

      <?php
      $items = [
        ["Inicio", "house-door-fill"],
        ["Usuarios", "person-badge-fill"],
        ["Orden de trabajo", "wrench-adjustable-circle-fill"],
        ["Registrar", "journal-plus"],
        ["Productos", "box-seam-fill"],
        ["Reportes", "graph-up-arrow"],
        ["Configuración", "gear-fill"],
        ["Historial", "clock-history"],
        ["Salir", "box-arrow-left"]
      ];

      $active = "Inicio"; // Simula que "Inicio" está activo

      foreach ($items as $item) {
        $isActive = ($item[0] == $active) ? "active bg-white text-primary fw-semibold" : "text-white";
        echo '
          <a href="#" class="nav-link d-flex align-items-center gap-2 rounded mb-2 px-3 py-2 ' . $isActive . '" 
             style="transition: background-color 0.3s;">
            <i class="bi bi-' . $item[1] . '"></i>
            <span class="d-none d-md-inline">' . $item[0] . '</span>
          </a>
        ';
      }
      ?>
    </nav>

    <!-- Contenido principal -->
    <main class="flex-grow-1 p-4" style="background-color: #edb6f3;">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <input type="text" class="form-control w-100 w-md-50" placeholder="Buscar...">
        <div class="d-flex align-items-center">
          <i class="bi bi-bell-fill text-danger fs-4 me-3"></i>
          <div class="rounded-circle bg-secondary" style="width: 30px; height: 30px;"></div>
        </div>
      </div>

      <h4>Bienvenido al panel del taller</h4>
      <p>Selecciona una opción del menú para comenzar.</p>
    </main>

  </div>

  <!-- Bootstrap JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
