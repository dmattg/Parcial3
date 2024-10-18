function editarUsuario(usuario_id, nombre, apellido, email, nacionalidad_id) {
    document.getElementById('nombre').value = nombre;
    document.getElementById('apellido').value = apellido;
    document.getElementById('email').value = email;
    document.getElementById('nacionalidad_id').value = nacionalidad_id;

    // Cambiar la acción del formulario para actualizar
    const form = document.querySelector('form');
    form.action = 'crud.php';
    form.querySelector('input[name="action"]').value = 'actualizar';
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'usuario_id';
    hiddenInput.value = usuario_id;
    form.appendChild(hiddenInput);
}