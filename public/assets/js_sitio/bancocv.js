// document.getElementById('btnSiguiente').addEventListener('click', function() {
    // Verificar si todos los campos están completos
    if (
        document.getElementById('NOMBRE_VACANTE').value === '' ||
        document.getElementById('CORREO_VACANTE').value === '' ||
        document.getElementById('TELEFONO_VACANTE').value === '' ||
        document.getElementById('CURP_VACANTE').value === '' ||
        // document.getElementById('SEXO_VACANTE').value === '' ||
        document.getElementById('FECHA_NACIMIENTO_VACANTE').value === '' ||
        document.getElementById('EDAD_VACANTE').value === ''
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




