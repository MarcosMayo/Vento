<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Gestión de Tipos de Servicios</h2>

        <div class="row">
            <div class="container mt-4">
                <div class="row">
                    <!-- Columna: Agregar Servicio -->
                    <div class="col-md-6">
                        <h4>Agregar Servicio</h4>
                        <form id="formServicio">
                            
                            <div class="mb-3">
                                <label>Nombre del servicio</label>
                                <input type="text" class="form-control" name="nombre_servicio" required>
                            </div>
                            <div class="mb-3">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Mano de obra ($)</label>
                                
                                <input type="number" class="form-control" name="mano_obra" id="manoObra" min="0" step="0.01" value="0" required>

                            </div>

                            <h5>Refacciones</h5>
                            <table class="table table-bordered" id="tablaRefacciones">
                                <thead>
                                    <tr>
                                        <th>Refacción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button type="button" class="btn btn-secondary mb-3" onclick="agregarFila()">+ Refacción</button>

                            <div class="mb-3">
                                  <strong>Total Refacciones: $<span id="totalRefacciones">0.00</span></strong><br>
                                <strong>Total: $<span id="totalServicio">0.00</span></strong>
                                
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                        </form>
                    </div>

                    <!-- Columna: Lista de Servicios -->
                    <div class="col-md-6">
                        
                        <h4>Servicios Registrados</h4>
                        <!-- Buscador -->
<input type="text" class="form-control mb-2" placeholder="Buscar servicio..." id="searchInputServicios">
                        <table class="table table-striped" id="tablaServicios">
                            <thead>
                                <tr>
                                   
                                    <th>Nombre</th>
                                    <th>descripcion</th>
                                    <th>Refacciones</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody  id="tablaBodyServicios">
                                <!-- Servicios cargados desde el backend -->
                            </tbody>
                        </table>
                        <nav>
               
<!-- Paginación -->
<ul class="pagination justify-content-center" id="paginacionServicios"></ul>

            </nav>
                    </div>
                </div>
            </div>


        </div>
    </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/guarserv.js"></script>
<script src="../js/servicios.js"></script>
<script src="../js/autocomRef.js"></script>
<?php include("../plantillas/footer.php"); ?>