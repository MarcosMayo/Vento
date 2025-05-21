<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado','Encargado']); // To todos pueden ver esta vista
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
  <div class="container-fluid">
    <h2 class="text-center mb-4">Crear Orden de Trabajo</h2>
    <form id="formOrdenTrabajo">
      <div class="row g-3">

        <!-- CLIENTE -->
<div class="col-md-6">
  <label for="cliente" class="form-label">Cliente</label>
 <select id="cliente" class="form-select" style="width: 100%"></select>


    <option value="">Selecciona un cliente</option>
    <!-- Opciones cargadas con JS -->
  </select>
</div>

<!-- MOTOCICLETA DEL CLIENTE -->
<div class="col-md-6">
  <label for="motocicleta" class="form-label">Motocicleta</label>
  <select id="motocicleta" name="motocicleta" class="form-select" disabled>
    <option value="">Primero selecciona un cliente</option>
  </select>
</div>


        <!-- SERVICIO (Autocompletado) -->
        <div class="col-md-6 position-relative">
          <label for="servicio_nombre" class="form-label">Servicio</label>
          <input type="text" class="form-control" id="servicio_nombre" placeholder="Buscar servicio..." autocomplete="off">
          <input type="hidden" name="servicio" id="servicio_id">
          <div id="sugerenciasServicios" class="position-absolute bg-white border w-100" style="z-index: 1000;"></div>
        </div>

        <!-- EMPLEADO -->
        <div class="col-md-6">
          <label for="empleado" class="form-label">Empleado asignado</label>
          <select id="empleado" name="empleado" class="form-select"></select>
        </div>

        <!-- FECHA Y HORA -->
        <div class="col-md-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" name="fecha" readonly>
        </div>

        <div class="col-md-3">
          <label for="hora" class="form-label">Hora</label>
          <input type="time" class="form-control" id="hora" name="hora" readonly>
        </div>

        <!-- ESTATUS -->
        <div class="col-md-6">
          <label for="estatus" class="form-label">Estatus</label>
          
          <input type="hidden" id="estatus" name="estatus" value="1">

        </div>
      </div>

      <hr>
      <h5>Refacciones del Servicio</h5>
      <div class="table-responsive mb-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Subtotal</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody id="tablaRefaccionesOrden"></tbody>
        </table>
      </div>
      <button type="button" class="btn btn-secondary mb-3" onclick="agregarFilaRefaccion()">+ Refacción</button>

      <div class="row">
        <div class="col-md-4">
          <label class="form-label">Mano de obra ($)</label>
          <input type="number" class="form-control" id="manoObraOrden" name="mano_obra" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Subtotal Refacciones ($)</label>
          <input type="text" class="form-control" id="subtotalRefOrden" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Total Final ($)</label>
          <input type="text" class="form-control" id="totalFinalOrden" readonly>
        </div>
      </div>

      <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">Guardar Orden de Trabajo</button>
      </div>
    </form>
  </div>
</main>

<?php include("../plantillas/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/cargar_motos_por_cliente.js"></script>
<script src="../js/selcts_orden.js"></script>
<script src="../js/autocompletar_motos.js"></script>
<script src="../js/autocompletar_servicios.js"></script>
<script src="../js/cargar_refacciones_servicio.js"></script>
<script src="../js/agregar_fila_refaccion.js"></script>
<script src="../js/enviar_orden_trabajo.js"></script>
