// // Fecha automática
// document.addEventListener('DOMContentLoaded', () => {
//     const hoy = new Date().toISOString().split('T')[0];
//     document.getElementById('fecha').value = hoy;

//     // Aquí puedes agregar tu lógica fetch para llenar selectores
//     // fetchMotocicletas();
//     // fetchServicios();
//     // fetchEmpleados();
// });

// document.addEventListener('DOMContentLoaded', () => {
//     const tbody = document.getElementById('tbodyRefacciones');
//     const totalOrden = document.getElementById('totalOrden');
//     const btnAgregar = document.getElementById('btnAgregarRefaccion');

//     function actualizarTotal() {
//         let total = 0;
//         tbody.querySelectorAll('tr').forEach(row => {
//             const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
//             const precio = parseFloat(row.querySelector('.precio').value) || 0;
//             const subtotal = cantidad * precio;
//             row.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
//             total += subtotal;
//         });
//         totalOrden.textContent = `$${total.toFixed(2)}`;
//     }

//     function agregarFila(refaccion = '') {
//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td><input type="text" name="refaccion[]" class="form-control" value="${refaccion}"></td>
//             <td><input type="number" name="cantidad[]" class="form-control cantidad" min="1" value="1"></td>
//             <td><input type="number" name="precio[]" class="form-control precio" step="0.01" min="0" value="0.00"></td>
//             <td class="subtotal">$0.00</td>
//             <td><button type="button" class="btn btn-danger btn-sm btnEliminar">Eliminar</button></td>
//         `;
//         tbody.appendChild(tr);
//         actualizarTotal();

//         tr.querySelector('.cantidad').addEventListener('input', actualizarTotal);
//         tr.querySelector('.precio').addEventListener('input', actualizarTotal);
//         tr.querySelector('.btnEliminar').addEventListener('click', () => {
//             tr.remove();
//             actualizarTotal();
//         });
//     }

//     btnAgregar.addEventListener('click', () => agregarFila());

//     // Si deseas agregar refacciones por defecto (de un servicio):
//     // agregarFila("Aceite 20W50");
//     // agregarFila("Filtro de aire");
// });




// === Variables globales ===
let precioServicioOriginal = 0;
let manoObraOriginal = 0;

// === Al cargar la página ===
document.addEventListener('DOMContentLoaded', () => {
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;
});

// === Manejo de refacciones dinámicas ===
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.getElementById('tbodyRefacciones');
    const totalRefaccionesVisual = document.getElementById('totalRefaccionesVisual');
    const totalRefaccionesTabla = document.getElementById('totalRefaccionesTabla');
    const totalFinalDisplay = document.getElementById('totalFinal'); // Asegúrate de tener este ID
    const manoObraVisual = document.getElementById('manoObraVisual'); // Asegúrate de tener este ID
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

    function agregarFila(refaccion = '', cantidad = 1, precio = 0.00) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="refaccion[]" class="form-control" value="${refaccion}"></td>
            <td><input type="number" name="cantidad[]" class="form-control cantidad" min="1" value="${cantidad}"></td>
            <td><input type="number" name="precio[]" class="form-control precio" step="0.01" min="0" value="${precio.toFixed(2)}"></td>
            <td class="subtotal">$0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm btnEliminar">Eliminar</button></td>
        `;
        tbody.appendChild(tr);
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

    btnAgregar.addEventListener('click', () => agregarFila());

    // === Cargar datos del servicio seleccionado ===
    window.cargarDatosDelServicio = function (idServicio) {
        fetch(`../logica/obtener_datos_servicio.php?id=${idServicio}`)
            .then(res => res.json())
            .then(data => {
                precioServicioOriginal = parseFloat(data.precio);
                tbody.innerHTML = ''; // Limpiar refacciones actuales
                data.refacciones.forEach(ref => {
                    agregarFila(ref.nombre, ref.cantidad, ref.precio_unitario);
                });

                const subtotalRefaccionesOriginal = data.refacciones.reduce((acc, ref) => {
                    return acc + (ref.precio_unitario * ref.cantidad);
                }, 0);

                manoObraOriginal = precioServicioOriginal - subtotalRefaccionesOriginal;
                actualizarTotalFinal();
            });
    };
});

