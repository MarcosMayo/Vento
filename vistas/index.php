<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']); // Solo los administradores pueden ver esta vista
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center">INICIO</h2>
        <!-- Aquí puedes colocar tu formulario, tabla, etc. -->
    </div>
</main>

<?php include("../plantillas/footer.php"); ?>
