<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario PHP</title>
    <link rel="stylesheet" href="../botstrap/bot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body class="bg-primary bg-gradient d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 400px; border-radius: 1rem;">
        
        <div class="text-center mb-4">
            
            <img src="../imagenes/image.png" alt="Logo del taller" class="img-fluid" style="max-width: 250px;">
        </div>

        
        <form  action = " ../vento/logica/loguear.php " method="POST">
            <h3 class="text-center mb-4">Login</h3>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control rounded-3" id="usuario" name="usuario" required placeholder="Usuario">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control rounded-3" id="clave" name="clave" required placeholder="Password">
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
