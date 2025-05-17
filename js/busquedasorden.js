$(document).ready(function () {
    // Buscar motocicleta
    $('#motocicleta').select2({
        placeholder: 'Buscar motocicleta...',
        minimumInputLength: 2,
        ajax: {
            url: '../logica/buscar_motocicleta.php',
            dataType: 'json',
            delay: 300,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(item => ({        
                    id: item.id,
                    text: item.modelo + ' - ' + item.numero_serie
                }))
            }),
            cache: true,
            error: (xhr, status, error) => console.error('Motocicleta:', error)
        }
    });

    // Buscar servicio
    $('#servicio').select2({
        placeholder: 'Buscar servicio...',
        minimumInputLength: 2,
        ajax: {
            url: '../logica/buscar_servicio.php',
            dataType: 'json',
            delay: 300,
            data: params => {
    console.log('Buscando empleado:', params.term);
    return { q: params.term };
},

            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(item => ({
                    id: item.id,
                    text: item.nombre + ' - $' + item.precio
                }))
            }),
            cache: true,
            error: (xhr, status, error) => console.error('Servicio:', error)
        }
    }).on('select2:select', function (e) {
        const idServicio = e.params.data.id;
        cargarDatosDelServicio(idServicio); // función definida por ti
    });

    // Buscar empleado
    $('#empleado').select2({
        placeholder: 'Buscar empleado...',
        minimumInputLength: 2,
        ajax: {
            url: '../logica/buscar_empleados.php',
            dataType: 'json',
            delay: 300,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(item => ({
                    id: item.id,
                    text: item.nombre + ' ' + item.apellido_paterno
                }))
            }),
            cache: true,
            error: (xhr, status, error) => console.error('Empleado:', error)
        }
    });
});
