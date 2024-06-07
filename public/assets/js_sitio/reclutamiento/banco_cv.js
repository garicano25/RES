

document.getElementById('CURP_CV').addEventListener('input', function() {
    var curp = this.value;
    var contador = document.getElementById('contador');
    contador.textContent = curp.length + '/18';

    var mensaje = document.getElementById('mensaje');
    if (curp.length === 18) {
        mensaje.textContent = 'Confirma tu CURP antes de continuar';
    } else {
        mensaje.textContent = '';
    }
});




document.getElementById('ULTIMO_GRADO_CV').addEventListener('change', function() {
    var selectedValue = this.value;
    document.getElementById('licenciatura-container').style.display = selectedValue === '4' ? 'block' : 'none';
    document.getElementById('posgrado-container').style.display = selectedValue === '5' ? 'block' : 'none';
    document.getElementById('posgrado-nombre-container').style.display = 'none'; // Hide posgrado name input initially
});

document.getElementById('TIPO_POSGRADO_CV').addEventListener('change', function() {
    document.getElementById('posgrado-nombre-container').style.display = this.value !== '0' ? 'block' : 'none';
});



document.addEventListener('DOMContentLoaded', function() {
    var avisoModal = new bootstrap.Modal(document.getElementById('avisoPrivacidadModal'), {
        backdrop: 'static',
        keyboard: false
    });
    avisoModal.show();

    document.getElementById('aceptoTerminos').addEventListener('click', function() {
        avisoModal.hide();
    });

    document.getElementById('noAceptoTerminos').addEventListener('click', function() {
        window.location.href = 'http://results-in-performance.com/';
    });
});
