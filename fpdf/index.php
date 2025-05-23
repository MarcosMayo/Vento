<!DOCTYPE html>
<html lang="es">
<?php
include("../Estructura/sesiones.php");
logueado();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <!-- Bootstrap CSS -->
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../Estilos/stilo.css" >
    <link rel="stylesheet" href="../Estilos/botstrap.css">
</head>
<body>
    <!-- Contenedor principal -->
    <div class="d-flex" id="wrapper">
        <!-- Menú lateral -->
        <nav class="bg-dark text-white p-3" id="sidebar">
            <h2 class="text-center">Menú</h2>
            <ul class="nav flex-column">
            <li class="nav-item">
                    <a class="nav-link text-white" href="Usuarios.php">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="citas.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="servicios.php">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="productos.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="marcas.php">Marcas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="proveedores.php">Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="venta.php">Venta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="reporte.php">Reportes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="clientes.php">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="empleados.php">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../Estructura/cerrar_sesion.php">Cerrar sesión</a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div class="w-100">
            <!-- Barra superior -->
            <header class="d-flex justify-content-between align-items-center bg-light p-3 shadow">
                <h3 class="m-0">Panel de Administración</h3>
                <img src="https://via.placeholder.com/40" alt="Ícono de la Empresa" class="rounded-circle">
            </header>

            <!-- Área de contenido -->
            <main class="p-4">
                <h1>Bienvenido al sistema de Juliz</h1>
                <p>Desde aquí puedes gestionar las citas, servicios y configuraciones de tu estética.</p>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
