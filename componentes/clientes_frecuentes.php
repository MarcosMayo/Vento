<div class="card">
  <div class="card-body">
    <h5 class="card-title">Clientes más frecuentes</h5>
    <p class="text-muted">Lista de los clientes con más servicios o compras.</p>

    <button class="btn btn-danger mb-3" onclick="exportarClientesFrecuentesPDF()">Exportar a PDF</button>

    <div id="tablaClientesFrecuentes"></div>
    <div id="paginacionClientesFrecuentes" class="text-center mt-2"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => cargarClientesFrecuentes(1));

function cargarClientesFrecuentes(pagina = 1) {
  fetch('../reportes/clientes_frecuentes.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ pagina })
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('tablaClientesFrecuentes').innerHTML = data.tabla;
      document.getElementById('paginacionClientesFrecuentes').innerHTML = data.paginacion;
    });
}

function exportarClientesFrecuentesPDF() {
  window.open('../reportes/pdf_clientes_frecuentes.php', '_blank');
}
</script>
