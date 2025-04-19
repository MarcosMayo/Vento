<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $recordar = isset($_POST['recordar']) ? 'Sí' : 'No';
    
    if (!empty($usuario)) {
        $mensaje = "<div class='alert alert-success'>Usuario: $usuario<br>Recordar: $recordar</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario PHP</title>
    <link rel="stylesheet" href="botstrap/bot.css">
</head>
<body class="bg-primary bg-gradient d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 400px; border-radius: 1rem;">
        
        <div class="text-center mb-4">
            
            <img src="image.png" alt="Logo del taller" class="img-fluid" style="max-width: 250px;">
        </div>

        <?php echo $mensaje ?? ''; ?>
        
        <form method="post">
            <h3 class="text-center mb-4">Login</h3>

            <div class="mb-3">
                <label for="usuario" class="form-label">Email</label>
                <input type="text" class="form-control rounded-3" id="usuario" name="usuario" required placeholder="usuario@gmail.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control rounded-3" id="password" name="password" required placeholder="Password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="recordar" name="recordar">
                <label class="form-check-label" for="recordar">Recordar sesión</label>
            </div>

            <button type="submit" class="btn btn-dark w-100 rounded-3">Iniciar Sesión</button>
        </form>
    </div>

   
</body>
</html>
