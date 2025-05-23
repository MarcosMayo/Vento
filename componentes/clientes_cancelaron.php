<div class="card">
  <div class="card-body">
    <h5 class="card-title">Clientes que cancelaron órdenes</h5>
    <p class="text-muted">Lista de clientes que han cancelado órdenes de trabajo.</p>

    <button class="btn btn-danger mb-3" onclick="exportarClientesCancelaronPDF()">Exportar a PDF</button>

    <div id="tablaClientesCancelaron"></div>
    <div id="paginacionClientesCancelaron" class="text-center mt-2"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => cargarClientesCancelaron(1));

function cargarClientesCancelaron(pagina = 1) {
  fetch('../reportes/clientes_cancelaron.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ pagina })
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('tablaClientesCancelaron').innerHTML = data.tabla;
      document.getElementById('paginacionClientesCancelaron').innerHTML = data.paginacion;
    });
}

function exportarClientesCancelaronPDF() {
  window.open('../reportes/pdf_clientes_cancelaron.php', '_blank');
}
</script>
