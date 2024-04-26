document.getElementById('btnSiguiente').addEventListener('click', function() {
    // Verificar si todos los campos están completos
    if (
        document.getElementById('nombre').value === '' ||
        document.getElementById('correo').value === '' ||
        document.getElementById('curp').value === '' ||
        document.getElementById('sexo').value === '' ||
        document.getElementById('telefono').value === '' ||
        document.getElementById('fecha_nacimiento').value === '' ||
        document.getElementById('edad').value === ''
    ) {
        // Mostrar alerta de SweetAlert2 con un temporizador de 2 segundos
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, completa todos los campos antes de continuar',
            timer: 1000, // Duración en milisegundos (2 segundos)
            timerProgressBar: true, // Barra de progreso del temporizador
            showConfirmButton: false // Ocultar botón de confirmación
        });
    } else {
        // Oculta el botón de siguiente
        document.getElementById('btnSiguiente').style.display = 'none';
        // Muestra el select de puestos
        document.getElementById('selectPuestos').classList.remove('d-none');
    }
});




