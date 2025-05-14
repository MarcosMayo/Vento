// Manejo de botones de editar y carga de datos al modal
document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById("editar_id_refaccion").value = this.dataset.id;
        document.getElementById("editar_nombre_refaccion").value = this.dataset.nombre;
        document.getElementById("editar_precio").value = this.dataset.precio;
        document.getElementById("editar_stock").value = this.dataset.stock;
        new bootstrap.Modal(document.getElementById("editarRefaccionModal")).show();
    });
});

// Enviar formulario de edición
const formEditar = document.getElementById("formEditarRefaccion");
if (formEditar) {
    formEditar.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("../crud/editar_refaccion.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                Swal.fire("Actualizado", data.mensaje, "success").then(() => location.reload());
            } else {
                Swal.fire("Error", data.mensaje || "Ocurrió un error", "error");
            }
        })
        .catch(() => Swal.fire("Error", "No se pudo conectar al servidor", "error"));
    });
}
