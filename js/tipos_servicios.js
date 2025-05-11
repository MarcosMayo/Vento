// CARGAR SERVICIOS
async function cargarServicios() {
    try {
        const response = await fetch("../crud/tipos_servicio_control.php?accion=obtener");
        const data = await response.json();

        const tbody = document.getElementById("tablaServicios");
        tbody.innerHTML = "";

        data.forEach(servicio => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${servicio.nombre_servicio}</td>
                <td>${servicio.descripcion}</td>
                <td>$${servicio.precio}</td>
                <td class="text-center">
                    <button class="btn btn-warning btn-sm" onclick='llenarFormularioEditar(${JSON.stringify(servicio)})'>Editar</button>
                </td>
            `;
            tbody.appendChild(fila);
        });
    } catch (error) {
        console.error("Error al cargar servicios:", error);
    }
}

// GUARDAR NUEVO SERVICIO
document.getElementById("formAgregarServicio").addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append("accion", "guardar");

    try {
        const response = await fetch("../crud/tipos_servicio_control.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            Swal.fire("Éxito", result.message, "success");
            this.reset();
            bootstrap.Modal.getInstance(document.getElementById("modalAgregarServicio")).hide();
            cargarServicios();
        } else {
            Swal.fire("Error", result.message, "error");
        }
    } catch (error) {
        console.error("Error al guardar servicio:", error);
    }
});

// LLENAR MODAL DE EDICIÓN
function llenarFormularioEditar(servicio) {
    document.getElementById("editarIdServicio").value = servicio.id_servicio;
    document.getElementById("editarNombreServicio").value = servicio.nombre_servicio;
    document.getElementById("editarDescripcionServicio").value = servicio.descripcion;
    document.getElementById("editarPrecioServicio").value = servicio.precio;

    const modal = new bootstrap.Modal(document.getElementById("modalEditarServicio"));
    modal.show();
}

// EDITAR SERVICIO
document.getElementById("formEditarServicio").addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append("accion", "editar");

    try {
        const response = await fetch("../crud/tipos_servicio_control.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            Swal.fire("Éxito", result.message, "success");
            bootstrap.Modal.getInstance(document.getElementById("modalEditarServicio")).hide();
            cargarServicios();
        } else {
            Swal.fire("Error", result.message, "error");
        }
    } catch (error) {
        console.error("Error al editar servicio:", error);
    }
});

// CARGAR AL INICIAR
document.addEventListener("DOMContentLoaded", cargarServicios);
