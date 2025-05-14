<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Ventas</h2>

        <!-- Selección de Refacciones -->
        <div class="mb-4">
            <label for="buscarRefaccion" class="form-label">Buscar productos o servicios:</label>
            <input type="text" id="buscarRefaccion" class="form-control" placeholder="Buscar por nombre...">
            <div class="list-group mt-2" id="listaRefacciones"></div>
        </div>
        

        <!-- Dentro de <main class="p-3"> -->
        <div class="table-responsive">
            <h5 class="mt-4">Productos y servicios agregados:</h5>
            <table class="table table-bordered align-middle text-center table-hover" id="tablaVenta">
                <thead class="table-dark">
                    <tr>
                        <th>Refacción</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2" id="totalVenta" class="fw-bold">$0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <div class="text-end">
            <button class="btn btn-success" id="btnFinalizarVenta">Finalizar Venta</button>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let carrito = [];

    const buscarInput = document.getElementById('buscarRefaccion');
    const listaRefacciones = document.getElementById('listaRefacciones');
    const tablaVentaBody = document.querySelector('#tablaVenta tbody');
    const totalVenta = document.getElementById('totalVenta');

    buscarInput.addEventListener('input', () => {
        const query = buscarInput.value.trim();
        if (query.length === 0) {
            listaRefacciones.innerHTML = '';
            return;
        }

        // Buscar refacciones
        fetch(`../crud/buscar_refacciones.php?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(refacciones => {
                listaRefacciones.innerHTML = '';
                refacciones.forEach(ref => {
                    const item = document.createElement('button');
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = `${ref.nombre_refaccion} - $${parseFloat(ref.precio).toFixed(2)} (Stock: ${ref.stock})`;
                    item.addEventListener('click', () => agregarAlCarrito({
                        tipo: 'refaccion',
                        id: `R-${ref.id_refaccion}`,
                        nombre: ref.nombre_refaccion,
                        precio: parseFloat(ref.precio),
                        stock: parseInt(ref.stock),
                        cantidad: 1
                    }));
                    listaRefacciones.appendChild(item);
                });
            });

        // Buscar servicios
        fetch(`../crud/buscar_servicios.php?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(servicios => {
                servicios.forEach(serv => {
                    const item = document.createElement('button');
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = `${serv.nombre_servicio} - $${parseFloat(serv.total).toFixed(2)}`;
                    item.addEventListener('click', () => agregarAlCarrito({
                        tipo: 'servicio',
                        id: `S-${serv.id_servicio}`,
                        nombre: serv.nombre_servicio,
                        precio: parseFloat(serv.total),
                        stock: 1,
                        cantidad: 1
                    }));
                    listaRefacciones.appendChild(item);
                });
            });
    });

    function agregarAlCarrito(item) {
        const existente = carrito.find(x => x.id === item.id);

        if (existente) {
            if (item.tipo === 'refaccion') {
                if (existente.cantidad < existente.stock) {
                    existente.cantidad += 1;
                } else {
                    Swal.fire("Stock insuficiente", "No puedes agregar más unidades.", "warning");
                }
            } else {
                Swal.fire("Ya agregado", "Este servicio ya está en el carrito.", "info");
            }
        } else {
            carrito.push(item);
        }

        renderCarrito();
        listaRefacciones.innerHTML = '';
        buscarInput.value = '';
    }

    function renderCarrito() {
        tablaVentaBody.innerHTML = '';
        let total = 0;

        carrito.forEach((item, index) => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.nombre}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>
                    <input type="number" min="1" max="${item.stock}" value="${item.cantidad}"
                        class="form-control form-control-sm" data-index="${index}" ${item.tipo === 'servicio' ? 'readonly' : ''}>
                </td>
                <td>$${subtotal.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm" onclick="eliminarItem(${index})">Quitar</button></td>
            `;
            tablaVentaBody.appendChild(row);
        });

        totalVenta.textContent = `$${total.toFixed(2)}`;
    }

    window.eliminarItem = function(index) {
        carrito.splice(index, 1);
        renderCarrito();
    };

    tablaVentaBody.addEventListener('change', (e) => {
        if (e.target.tagName === 'INPUT') {
            const index = parseInt(e.target.dataset.index);
            const nuevaCantidad = parseInt(e.target.value);

            if (isNaN(nuevaCantidad) || nuevaCantidad <= 0) {
                Swal.fire("Cantidad inválida", "Ingresa un número mayor a cero.", "warning");
                e.target.value = carrito[index].cantidad;
                return;
            }

            if (nuevaCantidad > carrito[index].stock) {
                Swal.fire("Stock insuficiente", "La cantidad excede el stock disponible.", "warning");
                e.target.value = carrito[index].cantidad;
                return;
            }

            carrito[index].cantidad = nuevaCantidad;
            renderCarrito();
        }
    });

    document.getElementById("btnFinalizarVenta").addEventListener("click", () => {
        if (carrito.length === 0) {
            Swal.fire("Carrito vacío", "Agrega al menos una refacción o servicio.", "info");
            return;
        }

        fetch('../crud/finalizar_venta.php', {
            method: 'POST',
            body: JSON.stringify({ carrito }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                Swal.fire("Venta registrada", data.mensaje, "success").then(() => location.reload());
            } else {
                Swal.fire("Error", data.mensaje || "Ocurrió un error", "error");
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo conectar al servidor", "error"));
    });
});
</script>


<?php include("../plantillas/footer.php"); ?>