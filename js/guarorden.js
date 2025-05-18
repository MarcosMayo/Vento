document.getElementById('formOrdenTrabajo').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
}


for (let pair of formData.entries()) {
    console.log(pair[0]+ ': ' + pair[1]);
}
  
    

    fetch('../crud/guardar_orden_trabajo.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(text => {
        //console.log(data); // <-- para depurar
         console.log('Respuesta cruda del servidor:', text);
        if (data.status === 'success') { // <-- asegúrate de que coincida con el JSON que devuelve tu PHP
             Swal.fire('Éxito', data.message, 'success');
            form.reset();
            document.getElementById('tbodyRefacciones').innerHTML = '';
            actualizarTotalFinal();
        } else {
            Swal.fire('Error', data.message || 'No se pudo guardar', 'error');

        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Error al enviar datos', 'error');
    });
});
