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
        header("Location: ../vistas/sin_acceso.php");
        exit;
    }
}
