<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">

        <!-- Título principal -->
        <h2 class="text-center mb-4">Usuarios</h2>

        <!-- Botón para añadir nuevo usuario -->
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
                Nuevo usuario
            </button>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-responsive">  
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jose Lopez</td>
                        <td>(414) 907-1274</td>
                        <td>05/03/2025</td>
                        <td>Jose@gmail.com</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>Eduardo Olan</td>
                        <td>(318) 698-9889</td>
                        <td>01/03/2025</td>
                        <td>Eduardo@gmail.com</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        

</main>
<?php include("../modales/modalUsuario.php"); ?>
<?php include("../plantillas/footer.php"); ?>