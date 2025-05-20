function eliminarUsuario(id) {
  Swal.fire({
    title: 'Confirmar acción',
    text: 'Para eliminar este usuario, ingresa tu contraseña de administrador:',
    input: 'password',
    inputAttributes: {
      autocapitalize: 'off',
      autocomplete: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar',
    preConfirm: (password) => {
      if (!password) {
        Swal.showValidationMessage('La contraseña es obligatoria');
      }
      return password;
    }
  }).then(async (result) => {
    if (result.isConfirmed) {
      const formData = new URLSearchParams();
      formData.append('id', id);
      formData.append('pass_admin', result.value);

      const res = await fetch('../crud/eliminarusuario.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData.toString()
      });

      const data = await res.json();

      if (data.success) {
        Swal.fire('Eliminado', data.message, 'success');
        cargarUsuarios(); // Recargar tabla
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    }
  });
}
