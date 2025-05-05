<div class="d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar-toggle">
        <div class="sidebar-logo">
            <a href="#">CANUL servicios y refacciones</a>
        </div>
        <ul class="sidebar-nav p-0">
            <li class="sidebar-header">Herramientas y componentes</li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#perfilMenu" aria-expanded="false" aria-controls="perfilMenu">
                    <i class="lni lni-user"></i>
                    <span>Perfil</span>
                </a>
                <ul id="perfilMenu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../vistas/usuarios.php" class="sidebar-link">
                            <i class="lni lni-users"></i> Usuarios
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="../vistas/ordenes_trabajo.php" class="sidebar-link">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Ordenes de trabajo</span>
                </a>
            </li>
            <li class="sidebar-header">Sistema</li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#registrar" aria-expanded="true" aria-controls="registrar">
                    <i class="bi bi-person-plus"></i>
                    <span>Registrar</span>
                </a>
                <ul id="registrar" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../vistas/clientes.php" class="sidebar-link">
                            <i class="bi bi-person"></i> Cliente
                        </a>
                    </li>
                    <li class="sidebar-item" class="sidebar-dropdown list-unstyled collapse">
                        <a href="../vistas/moto.php" class="sidebar-link">
                            <i class="bi bi-bicycle"></i> Motos
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="bi bi-box"></i><span>Refacciones</span></a></li>
            <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="bi bi-bar-chart-line"></i><span>Reportes</span></a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link"><i class="lni lni-exit"></i><span>Salir</span></a>
        </div>
    </aside>

    <div class="main">
        <nav class="navbar navbar-expand">
            <button class="toggler-btn" type="button">
                <i class="lni lni-text-align-left"></i>
            </button>
        </nav>