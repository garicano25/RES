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
            timer: 1500, // Duración en milisegundos (2 segundos)
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


$(document).ready(function() {
    // Manejar el evento de entrada en el campo de CURP
    $('#curp').on('input', function() {
        var curp = $(this).val();
        if (curp.length === 18) {
            var fechaNacimientoString = curp.substring(8, 10) + '-' + curp.substring(6, 8) + '-' + curp.substring(4, 6);
            var fechaNacimiento = new Date(fechaNacimientoString);
            $('#fecha_nacimiento').val(fechaNacimientoString);
            calcularEdadYRellenar(fechaNacimiento);
            $('#fecha_nacimiento').prop('readonly', true); // Desactivar la edición después de completar automáticamente
        }
    });
    
    // Función para calcular la edad y rellenar el campo correspondiente
    function calcularEdadYRellenar(fechaNacimiento) {
        if (!isNaN(fechaNacimiento.getTime())) {
            var hoy = new Date();
            var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            var mes = hoy.getMonth() - fechaNacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            
            $('#edad').val(edad);
            console.log('Edad calculada:', edad); // Mensaje de consola para mostrar la edad calculada
        }
    }
});


