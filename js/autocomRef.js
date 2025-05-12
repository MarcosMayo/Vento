// Agregar nueva fila de refacción
function agregarFila() {
    const fila = document.createElement('tr');
    fila.innerHTML = `
        <td class="position-relative">
            <input type="text" class="form-control input-refaccion" placeholder="Buscar refacción">
            <input type="hidden" class="id-refaccion">
            <ul class="lista-sugerencias list-group position-absolute w-100 z-3"></ul>
        </td>
        <td><input type="number" class="form-control cantidad-refaccion" value="1" min="1"></td>
        <td><input type="text" class="form-control precio-refaccion" readonly></td>
        <td><input type="text" class="form-control subtotal-refaccion" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
    `;
    document.querySelector('#tablaRefacciones tbody').appendChild(fila);
    activarBuscador(fila);
    recalcularTotales();
}

// Autocompletado de refacción
function activarBuscador(fila) {
    const input = fila.querySelector('.input-refaccion');
    const lista = fila.querySelector('.lista-sugerencias');
    const idHidden = fila.querySelector('.id-refaccion');
    const precioInput = fila.querySelector('.precio-refaccion');
    const cantidadInput = fila.querySelector('.cantidad-refaccion');
    const subtotalInput = fila.querySelector('.subtotal-refaccion');

    input.addEventListener('input', () => {
        const termino = input.value.trim();
        if (termino.length < 2) {
            lista.innerHTML = '';
            return;
        }

        fetch(`../logica/buscar_refacciones.php?q=${termino}`)
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                 console.log(data); // ✅ Añade esto
                data.forEach(ref => {
                    const item = document.createElement('li');
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = ref.nombre;
                    item.addEventListener('click', () => {
                        input.value = ref.nombre;
                        idHidden.value = ref.id;
                        const precio = parseFloat(ref.precio);
precioInput.value = isNaN(precio) ? '0.00' : precio.toFixed(2);

                        lista.innerHTML = '';
                        calcularSubtotal();
                    });
                    lista.appendChild(item);
                });
            });
    });

    cantidadInput.addEventListener('input', calcularSubtotal);

    function calcularSubtotal() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precio = parseFloat(precioInput.value) || 0;
        const subtotal = cantidad * precio;
        subtotalInput.value = subtotal.toFixed(2);
        recalcularTotales();
    }
}

// Eliminar fila
function eliminarFila(boton) {
    boton.closest('tr').remove();
    recalcularTotales();
}

// Recalcular totales
function recalcularTotales() {
    let totalRefacciones = 0;
    document.querySelectorAll('.subtotal-refaccion').forEach(input => {
        totalRefacciones += parseFloat(input.value) || 0;
    });

    const manoObra = parseFloat(document.getElementById('manoObra').value) || 0;
    const totalServicio = totalRefacciones + manoObra;

    document.getElementById('totalRefacciones').textContent = totalRefacciones.toFixed(2);
    document.getElementById('totalServicio').textContent = totalServicio.toFixed(2);
}
