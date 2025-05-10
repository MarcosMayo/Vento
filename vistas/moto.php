<?php
require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']);
?>
<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>
<main class="p-3">
    <div class="container-fluid">

        <!-- Título principal -->
        <h2 class="text-center mb-4">Motos</h2>


        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarMotoModal">
                Nueva moto
            </button>
        </div>
        <div class="mb-3">
            <input type="text" id="searchInputMotos" class="form-control" placeholder="Buscar por marca o modelo...">
        </div>

        <!-- Tabla de motos -->
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-bicycle me-2"></i>Cliente</th>
                        <th scope="col"><i class="bi bi-bicycle me-2"></i>Marca</th>
                        <th scope="col"><i class="bi bi-bicycle me-2"></i>Modelo</th>
                        <th scope="col"><i class="bi bi-calendar me-2"></i>Año</th>
                        <th scope="col"><i class="bi bi-list-columns-reverse me-2"></i>Numero de serie</th>
                        <th scope="col"><i class="bi bi-chat-left-text me-2"></i>Fecha de registro</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaBodyMotos">

            </table>
            <nav>
                <ul class="pagination" id="paginacionMotos"></ul>
            </nav>
        </div>

        <!-- Modal Agregar Moto -->
        <div class="modal fade" id="agregarMotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formMoto">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Agregar Motocicleta</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">


                            <div class="mb-3" id="buscador-representante">
                                <input type="text" id="input-cliente" class="form-control custom-input" />
                                <input name="id_cliente" type="hidden" id="input-id-cliente" class="form-control custom-input" />
                                <div id="contenedor-sugerencias" class="position-absolute w-100" style="z-index: 1051;"></div>
                            </div>


                            <div class="mb-3">
                                <label>Marca</label>
                                <input type="text" class="form-control" name="marca" required>
                            </div>

                            <div class="mb-3">
                                <label>Modelo</label>
                                <input type="text" class="form-control" name="modelo" required>
                            </div>

                            <div class="mb-3">
                                <label>Año</label>
                                <input type="text" class="form-control" name="anio" required>
                            </div>

                            <div class="mb-3">
                                <label>Número de serie</label>
                                <input type="text" class="form-control" name="numero_serie" required>
                            </div>

                            <div class="mb-3">
                                <label>Fecha de ingreso</label>
                                <input type="date" class="form-control" name="fecha_registro" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Moto -->
        <div class="modal fade" id="editarMotoModal" tabindex="-1" aria-labelledby="editarMotoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEditarMoto">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Editar Motocicleta</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">

                            <!-- Campo oculto para ID de la moto -->
                            <input type="hidden" name="id_moto" id="editar-id-motocicleta">

                            <div class="mb-3">
                                <label>Cliente</label>
                                <input type="text" name="id_cliente" class="form-control" id="editar-cliente" disabled>
                            </div>


                            <div class="mb-3">
                                <label>Marca</label>
                                <input type="text" class="form-control" name="marca" id="editar-marca" required>
                            </div>

                            <div class="mb-3">
                                <label>Modelo</label>
                                <input type="text" class="form-control" name="modelo" id="editar-modelo" required>
                            </div>

                            <div class="mb-3">
                                <label>Año</label>
                                <input type="text" class="form-control" name="anio" id="editar-anio" required>
                            </div>

                            <div class="mb-3">
                                <label>Número de serie</label>
                                <input type="text" class="form-control" name="numero_serie" id="editar-numero-serie" required>
                            </div>

                            <div class="mb-3">
                                <label>Fecha de ingreso</label>
                                <input type="date" class="form-control" name="fecha_registro" id="editar-fecha-registro" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/editmotos.js"></script>
<script src="../js/guarmo.js"></script>
<script src="../js/motos.js"></script>
<script src="../js/elimoto.js"></script>
<script src="../js/motos.js"></script>
<script src="../js/autocompletado.js"></script>
<!-- <script src="../js/buscarc.js"></script> -->
<?php include("../plantillas/footer.php"); ?>