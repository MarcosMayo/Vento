// GUARDAR ORDEN
const formAgregar = document.getElementById("formAgregarOrden");
formAgregar.addEventListener("submit", async function (e) {
    e.preventDefault();
    

    const formData = new FormData(formAgregar);
    formData.append("accion", "guardar");
    

    try {
        const response = await fetch("../crud/ordenes_control.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Orden registrada',
                text: result.message,
                timer: 2000,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById("agregarOrdenModal"));
            modal.hide();
            formAgregar.reset();
            cargarOrdenes(); // actualiza tabla
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message
            });
        }
    } catch (error) {
        console.error("Error al guardar orden:", error);
    }
});

// EDITAR ORDEN
const formEditar = document.getElementById("formEditarOrden");
formEditar.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(formEditar);
    formData.append("accion", "editar");

    try {
        const response = await fetch("../crud/ordenes_control.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Orden actualizada',
                text: result.message,
                timer: 2000,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById("editarOrdenModal"));
            modal.hide();
            cargarOrdenes(); // actualiza tabla
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message
            });
        }
    } catch (error) {
        console.error("Error al editar orden:", error);
    }
});

// Cargar servicios al iniciar
async function cargarServicios() {
    try {
        const response = await fetch("../crud/obtener_servicios.php");
        const servicios = await response.json();

        const selectServicio = document.getElementById("tipo_servicio");

        servicios.forEach(servicio => {
            const option = document.createElement("option");
            option.value = servicio.id;
            option.textContent = servicio.nombre;
            option.dataset.descripcion = servicio.descripcion;
            selectServicio.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar servicios:", error);
    }
}

// Mostrar descripción al seleccionar un servicio
document.getElementById("tipo_servicio").addEventListener("change", function () {
    const descripcionDiv = document.getElementById("descripcion_servicio");
    const selectedOption = this.options[this.selectedIndex];
    const descripcion = selectedOption.dataset.descripcion || "No hay descripción disponible.";
    descripcionDiv.textContent = descripcion;
});

// Ejecutar al cargar la página
document.addEventListener("DOMContentLoaded", function () {
    cargarServicios();
});
