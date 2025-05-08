document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formMoto');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Obtener los datos del formulario
        const formData = new FormData(form);
        // Imprimir en consola para ver qué datos se están enviando
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        try {
            const response = await fetch('../crud/guardarmoto.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} ${response.statusText}`);
            }

            const rawText = await response.text();
            console.log("Texto recibido del servidor:", rawText); // 🔍 Aquí verás lo que está mal

            let data;
            try {
                data = JSON.parse(rawText);
            } catch (jsonError) {
                throw new Error("La respuesta no es un JSON válido. Verifica que guardarmoto.php no imprima errores o texto adicional.");
            }

            console.log("Respuesta parseada:", data);

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Motocicleta guardada!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('agregarMotoModal'));
                modal.hide();

                // Limpiar formulario
                form.reset();

                // Recargar tabla de motocicletas
                cargarMotos(); // Asegúrate de tener esta función para cargar los datos actualizados de la tabla
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: data.message || 'Ocurrió un error desconocido'
                });
            }

        } catch (error) {
            console.error("Error capturado:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error inesperado'
            });
        }
    });
});
