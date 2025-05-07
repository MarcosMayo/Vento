document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formMoto');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Obtener los datos del formulario
        const formData = new FormData(form);
        // Imprimir en consola para ver qué datos se están enviando
    for (let pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]);
    }

        try {
            const response = await fetch('./crud/guardarmoto.php', {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                const data = await response.json();
                console.log(data);  // Ver la respuesta en la consola
            
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Motocicleta guardada!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
            
                    
                        
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar',
                        text: data.message || 'Ocurrió un error desconocido'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la respuesta',
                    text: 'El servidor respondió con un error: ' + response.statusText
                });
            }
            
        } catch (error) {
            // Manejo de error en caso de problemas con la red
            Swal.fire({
                icon: 'error',
                title: 'Error de red',
                text: 'No se pudo conectar con el servidor.'
            });
        }
    });
});
