<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Taller</title>
  <link rel="stylesheet" href="botstrap/bot.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

  <div class="d-flex flex-column flex-md-row vh-100">

    <!-- Barra lateral -->
    <div class="bg-primary text-white p-3" style="width: 240px;">
      <div class="mb-4 fs-4 fw-bold">🏍 TALLER</div>

      <?php
      $items = [
        ["Inicio", "house-door-fill", "bg-info"],
        ["Usuarios", "person-badge-fill", "bg-primary"],
        ["Orden de trabajo", "wrench-adjustable-circle-fill", "bg-danger"],
        ["Registrar", "journal-plus", "bg-success"],
        ["Productos", "box-seam-fill", "bg-warning"],
        ["Reportes", "graph-up-arrow", "bg-secondary"],
        ["Configuración", "gear-fill", "bg-dark"],
        ["Historial", "clock-history", "bg-light text-dark border"],
        ["Salir", "box-arrow-left", "bg-danger"]
      ];

      foreach ($items as $item) {
        echo '
          <a href="#" class="d-flex align-items-center gap-3 text-white text-decoration-none mb-2 px-2 py-2 rounded bg-opacity-10 bg-white-hover">
            <div class="d-flex justify-content-center align-items-center ' . $item[2] . ' rounded-circle" style="width: 36px; height: 36px;">
              <i class="bi bi-' . $item[1] . '"></i>
            </div>
            <span>' . $item[0] . '</span>
          </a>
        ';
      }
      ?>
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow-1 p-4" style="background-color: #edb6f3;">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <input type="text" class="form-control w-100 w-md-50" placeholder="Buscar...">
      </div>

      <h4>Bienvenido al panel del taller</h4>
      <p>Selecciona una opción del menú para comenzar.</p>
    </div>

  </div>

  <!-- Pequeño script para hover (sin CSS externo) -->
  <script>
    document.querySelectorAll('.bg-white-hover').forEach(item => {
      item.addEventListener('mouseenter', () => {
        item.classList.add('bg-white', 'bg-opacity-10');
      });
      item.addEventListener('mouseleave', () => {
        item.classList.remove('bg-white', 'bg-opacity-10');
      });
    });
  </script>

</body>
</html>