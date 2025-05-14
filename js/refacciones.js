document.addEventListener('DOMContentLoaded', () => {
    // Búsqueda en tiempo real
    const searchInput = document.getElementById('searchInputRefacciones');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tablaRefacciones tr');
            
            rows.forEach(row => {
                const nombre = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = nombre.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Manejo del formulario para agregar refacción
    const formRefaccion = document.getElementById('formAgregarRefaccion');
    if (formRefaccion) {
        formRefaccion.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validación del precio
            const precioInput = formRefaccion.querySelector('input[name="precio"]');
            if (parseFloat(precioInput.value) <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe ser mayor a 0'
                });
                return;
            }

            const formData = new FormData(formRefaccion);

            try {
                const response = await fetch('../crud/guardar_refaccion.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }

                const data = await response.json();

                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Refacción guardada!',
                        text: data.mensaje,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.mensaje || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ocurrió un error al conectar con el servidor'
                });
            }
        });
    }

    // Manejo de botones de editar
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = this.getAttribute('data-precio');
            
            // Llenar formulario de edición (debes implementar este modal)
            console.log('Editar refacción:', {id, nombre, precio});
        });
    });

    // Manejo de botones de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function() {
            const idRefaccion = this.getAttribute('data-id');
            eliminarRefaccion(idRefaccion);
        });
    });
});

async function eliminarRefaccion(id) {
    const confirmacion = await Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (confirmacion.isConfirmed) {
        try {
           const response = await fetch(`../crud/eliminar_refaccion.php?id=${id}`);
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const data = await response.json();

            if (data.status === 'ok') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: data.mensaje,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(data.mensaje || 'Error al eliminar');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al conectar con el servidor'
            });
        }
    }
}