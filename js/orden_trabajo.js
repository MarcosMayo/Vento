// === Variables globales ===
let precioServicioOriginal = 0;
let manoObraOriginal = 0;

// === Al cargar la página ===
document.addEventListener('DOMContentLoaded', () => {
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;

    const tbody = document.getElementById('tbodyRefacciones');
    const totalRefaccionesVisual = document.getElementById('totalRefaccionesVisual');
    const totalRefaccionesTabla = document.getElementById('totalRefaccionesTabla');
    const totalFinalDisplay = document.getElementById('totalFinal');
    const manoObraVisual = document.getElementById('manoObraVisual');
    const btnAgregar = document.getElementById('btnAgregarRefaccion');

    function actualizarTotalFinal() {
        const totalRefacciones = Array.from(tbody.querySelectorAll('tr')).reduce((acc, row) => {
            const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(row.querySelector('.precio').value) || 0;
            return acc + (cantidad * precio);
        }, 0);

        const totalFinal = totalRefacciones + manoObraOriginal;

        totalRefaccionesVisual.textContent = `$${totalRefacciones.toFixed(2)}`;
        totalRefaccionesTabla.textContent = `$${totalRefacciones.toFixed(2)}`;
        totalFinalDisplay.textContent = `$${totalFinal.toFixed(2)}`;
        manoObraVisual.textContent = `$${manoObraOriginal.toFixed(2)}`;
    }

    function agregarFila(idRefaccion = '', nombreRefaccion = '', cantidad = 1, precio = 0.00) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="position-relative">
                <input type="text" class="form-control nombre-refaccion" placeholder="Buscar refacción..." value="${nombreRefaccion}">
                <input type="hidden" name="refaccion[]" class="id-refaccion" value="${idRefaccion}">
            </td>
            <td><input type="number" name="cantidad[]" class="form-control cantidad" min="1" value="${cantidad}"></td>
            <td><input type="number" name="precio[]" class="form-control precio" step="0.01" min="0" value="${precio.toFixed(2)}" readonly></td>
            <td class="subtotal">$0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm btnEliminar">Eliminar</button></td>
        `;
        tbody.appendChild(tr);

        const inputNombre = tr.querySelector('.nombre-refaccion');
        const inputId = tr.querySelector('.id-refaccion');

        configurarAutocomplete(inputNombre, inputId);

        calcularSubtotalFila(tr);
        actualizarTotalFinal();

        tr.querySelector('.cantidad').addEventListener('input', () => {
            calcularSubtotalFila(tr);
            actualizarTotalFinal();
        });

        tr.querySelector('.precio').addEventListener('input', () => {
            calcularSubtotalFila(tr);
            actualizarTotalFinal();
        });

        tr.querySelector('.btnEliminar').addEventListener('click', () => {
            tr.remove();
            actualizarTotalFinal();
        });
    }

    function calcularSubtotalFila(tr) {
        const cantidad = parseFloat(tr.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(tr.querySelector('.precio').value) || 0;
        const subtotal = cantidad * precio;
        tr.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
    }

    function configurarAutocomplete(input, hiddenInput) {
        input.addEventListener('input', () => {
            const query = input.value;

            if (query.length < 2) return;

            fetch(`../logica/buscar_refac_orden.php?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    mostrarSugerencias(data, input, hiddenInput);
                })
                .catch(err => {
                    console.error('Error al buscar refacciones:', err);
                });
        });
    }

    function mostrarSugerencias(refacciones, input, hiddenInput) {
        let lista = document.createElement('ul');
        lista.classList.add('list-group', 'position-absolute');
        lista.style.zIndex = 1000;
        lista.style.width = '100%';

        refacciones.forEach(ref => {
            const item = document.createElement('li');
            item.classList.add('list-group-item', 'list-group-item-action');
            item.textContent = ref.nombre;
            item.addEventListener('click', () => {
                input.value = ref.nombre;
                hiddenInput.value = ref.id;
                    // Buscar el input de precio en la misma fila y asignar el precio
    const fila = input.closest('tr');
const inputPrecio = fila.querySelector('input[name="precio[]"]');
 if(inputPrecio) {
        inputPrecio.value = ref.precio || 0;
        // Opcional: actualizar subtotal y totales
        calcularSubtotalFila(fila);
        actualizarTotalFinal();
    }
                
                lista.remove();
            });
            lista.appendChild(item);
        });

        input.addEventListener('blur', () => {
    setTimeout(() => {
        const ul = input.parentNode.querySelector('ul');
        if (ul) ul.remove();
    }, 200); // para permitir que el usuario haga click
});


        input.parentNode.appendChild(lista);
    }

    // Botón para agregar una fila vacía
    btnAgregar.addEventListener('click', () => agregarFila());

    // Cargar datos de un servicio ya registrado
    window.cargarDatosDelServicio = function (idServicio) {
        fetch(`../logica/obtener_datos_servicio.php?id=${idServicio}`)
            .then(res => res.json())
            .then(data => {
                precioServicioOriginal = parseFloat(data.precio);
                tbody.innerHTML = ''; // Limpiar refacciones actuales

                data.refacciones.forEach(ref => {
                    agregarFila(ref.id_refaccion, ref.nombre, ref.cantidad, ref.precio_unitario);
                });

                const subtotalRefaccionesOriginal = data.refacciones.reduce((acc, ref) => {
                    return acc + (ref.precio_unitario * ref.cantidad);
                }, 0);

                manoObraOriginal = precioServicioOriginal - subtotalRefaccionesOriginal;
                actualizarTotalFinal();
            });
    };
});
