const formularios = document.querySelectorAll('.needs-validation');

formularios.forEach((formulario) => {
    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        formulario.classList.add('was-validated');
        if (formulario.checkValidity()) {
            formulario.querySelector('.alert').classList.remove('d-none');
        }
    });
});