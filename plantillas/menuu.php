<?php
$currentPage = basename($_SERVER['PHP_SELF']);

$ordenPages = ['orden.php', 'vista_ordenes.php'];
$catalogoPages = ['clientes.php', 'moto.php', 'empleados.php', 'tipos_servicios.php', 'refacciones.php'];
$usuariosPages = ['usuarios.php'];
?>

<div class="d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar-toggle">
        <div class="sidebar-logo">
            <a href="#">CANUL servicios y refacciones</a>
        </div>

        <ul class="sidebar-nav p-0">
            <!-- PRINCIPAL -->
             <li class="sidebar-header">Principal</li>

<li class="sidebar-item">
    <a href="../vistas/index.php" class="sidebar-link <?= $currentPage == 'index.php' ? 'active' : '' ?>">
        <i class="bi bi-house-door-fill"></i>
        <span>Inicio</span>
    </a>
</li>

            <li class="sidebar-header">Principal</li>

            <!-- Órdenes de Trabajo -->
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                   data-bs-target="#ordenesMenu"
                   aria-expanded="<?= in_array($currentPage, $ordenPages) ? 'true' : 'false' ?>"
                   aria-controls="ordenesMenu">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Órdenes de Trabajo</span>
                </a>
                <ul id="ordenesMenu" class="sidebar-dropdown list-unstyled collapse <?= in_array($currentPage, $ordenPages) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../vistas/orden.php" class="sidebar-link <?= $currentPage == 'orden.php' ? 'active' : '' ?>">
                            <i class="bi bi-plus-circle"></i> Crear Orden
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../vistas/vista_ordenes.php" class="sidebar-link <?= $currentPage == 'vista_ordenes.php' ? 'active' : '' ?>">
                            <i class="bi bi-list-ul"></i> Ver Órdenes
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Ventas -->
            <li class="sidebar-item">
                <a href="../vistas/ventas.php" class="sidebar-link <?= $currentPage == 'ventas.php' ? 'active' : '' ?>">
                    <i class="bi bi-cart-fill"></i>
                    <span>Ventas</span>
                </a>
            </li>

            <!-- Catálogos -->
            <li class="sidebar-header">Catálogos</li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                   data-bs-target="#registrar"
                   aria-expanded="<?= in_array($currentPage, $catalogoPages) ? 'true' : 'false' ?>"
                   aria-controls="registrar">
                    <i class="bi bi-folder"></i>
                    <span>Gestión de Datos</span>
                </a>
                <ul id="registrar" class="sidebar-dropdown list-unstyled collapse <?= in_array($currentPage, $catalogoPages) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../vistas/clientes.php" class="sidebar-link <?= $currentPage == 'clientes.php' ? 'active' : '' ?>">
                            <i class="bi bi-person"></i> Clientes
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../vistas/moto.php" class="sidebar-link <?= $currentPage == 'moto.php' ? 'active' : '' ?>">
                            <i class="bi bi-bicycle"></i> Motocicletas
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../vistas/empleados.php" class="sidebar-link <?= $currentPage == 'empleados.php' ? 'active' : '' ?>">
                            <i class="bi bi-person-badge"></i> Empleados
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../vistas/tipos_servicios.php" class="sidebar-link <?= $currentPage == 'tipos_servicios.php' ? 'active' : '' ?>">
                            <i class="bi bi-tools"></i> Servicios
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../vistas/refacciones.php" class="sidebar-link <?= $currentPage == 'refacciones.php' ? 'active' : '' ?>">
                            <i class="bi bi-box"></i> Refacciones
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Seguridad -->
            <li class="sidebar-header">Seguridad</li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                   data-bs-target="#perfilMenu"
                   aria-expanded="<?= in_array($currentPage, $usuariosPages) ? 'true' : 'false' ?>"
                   aria-controls="perfilMenu">
                    <i class="lni lni-user"></i>
                    <span>Usuarios</span>
                </a>
                <ul id="perfilMenu" class="sidebar-dropdown list-unstyled collapse <?= in_array($currentPage, $usuariosPages) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../vistas/usuarios.php" class="sidebar-link <?= $currentPage == 'usuarios.php' ? 'active' : '' ?>">
                            <i class="lni lni-users"></i> Gestionar Usuarios
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Reportes -->
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Reportes</span>
                </a>
            </li>
        </ul>

        <!-- Footer -->
        <div class="sidebar-footer">
            <a href="../logica/logout.php" class="sidebar-link">
                <i class="lni lni-exit"></i><span>Salir</span>
            </a>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="main">
        <nav class="navbar navbar-expand">
            <button class="toggler-btn" type="button">
                <i class="lni lni-text-align-left"></i>
            </button>
            <?php
            session_start();
            echo "Bienvenido, " . $_SESSION['usuario'] . " (" . $_SESSION['rol'] . ")";
            ?>
        </nav>
