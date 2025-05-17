//motocicletas
$(document).ready(function () {
    $('#motocicleta').select2({
        placeholder: 'Buscar motocicleta...',
        minimumInputLength: 2,
        ajax: {
            url: '../logica/buscar_motocicleta.php',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    q: params.term // término de búsqueda
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.modelo + ' - ' + item.numero_serie
                        };
                    })
                };
            },
            cache: true
        }
    });
});


// servicios

$('#servicio').select2({
    placeholder: 'Buscar servicio...',
    minimumInputLength: 2,
    ajax: {
        url: '../logica/buscar_servicio.php',
        dataType: 'json',
        delay: 300,
        data: function (params) {
            return {
                q: params.term
            };
        },
        processResults: function (data) {
            return {
                results: data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.nombre + ' - $' + item.precio
                    };
                })
            };
        },
        cache: true
    }
}).on('select2:select', function (e) {
    const idServicio = e.params.data.id;
    cargarDatosDelServicio(idServicio); // tu función para cargar refacciones
});

