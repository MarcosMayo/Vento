<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['rol'])) {
    header("Location: ../vistas/login.php");
    exit;
}

// Función para verificar rol
function verificar_rol($roles_permitidos = []) {
    if (!in_array($_SESSION['rol'], $roles_permitidos)) {
        // Opcional: redirigir a una página de error o mostrar mensaje
        echo "<h2>Acceso denegado. No tienes permisos para ver esta página.</h2>";
        exit;
    }
}
