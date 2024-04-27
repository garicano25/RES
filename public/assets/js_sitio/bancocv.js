 document.getElementById('btnSiguiente').addEventListener('click', function() {
    
    if (
        document.getElementById('NOMBRE_VACANTE').value === '' ||
        document.getElementById('CORREO_VACANTE').value === '' ||
        document.getElementById('TELEFONO_VACANTE').value === '' ||
        document.getElementById('CURP_VACANTE').value === '' ||
       
        document.getElementById('FECHA_NACIMIENTO_VACANTE').value === '' ||
        document.getElementById('EDAD_VACANTE').value === ''
    ) {
      
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, completa todos los campos antes de continuar',
            timer: 1000, 
            timerProgressBar: true,
            showConfirmButton: false 
        });
    } else {
        document.getElementById('btnSiguiente').style.display = 'none';
       
        document.getElementById('selectPuestos').classList.remove('d-none');
    }
});




