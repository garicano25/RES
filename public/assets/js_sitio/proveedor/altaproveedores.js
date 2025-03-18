//VARIABLES
ID_FORMULARIO_ALTA = 0





 function cualactividad() {
        var otrosCheckbox = document.getElementById('OTROS_ACTIVIDAD');
        var actividadDiv = document.getElementById('CUAL_ACTIVIAD');
        actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}
    


function cualdescuentos() {
    var otrosCheckbox = document.getElementById('OTROS_DESCUENTO');
    var actividadDiv = document.getElementById('CUAL_DESCUENTOS');
    
    // Verifica si "Otros" está seleccionado
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('DESCUENTOS_ACTIVIDAD_ECONOMICA');
    radios.forEach(function (radio) {
        radio.addEventListener("change", cualdescuentos);
    });
});

    
function vinculosres() {
    var otrosCheckbox = document.getElementById('VINCULO_SI');
    var actividadDiv = document.getElementById('DIV_VINCULOS');
    
    // Verifica si "Otros" está seleccionado
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('VINCULO_FAMILIAR');
    radios.forEach(function (radio) {
        radio.addEventListener("change", vinculosres);
    });
});

   
function numeroproveedor() {
    var otrosCheckbox = document.getElementById('SI_NUMEROPROVEEDOR');
    var actividadDiv = document.getElementById('DIV_NUMEROPROVEEDOR');
    
    // Verifica si "Otros" está seleccionado
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('SERVICIOS_PEMEX');
    radios.forEach(function (radio) {
        radio.addEventListener("change", numeroproveedor);
    });
});



document.addEventListener("DOMContentLoaded", function () {
    var textarea = document.getElementById("TERMINOS_IMPORTANCIAS_ALTA");
    var counter = document.createElement("span");
    counter.id = "charCounter";
    counter.style.display = "block";
    counter.style.marginTop = "5px";
    counter.style.color = "red";
    
    textarea.parentNode.appendChild(counter);

    textarea.addEventListener("input", function () {
        if (this.value.length > 300) {
            this.value = this.value.substring(0, 300); // Limita a 300 caracteres
        }
        counter.textContent = `${this.value.length}/300`; // Muestra caracteres escritos / total
    });

    counter.textContent = "0/300";
});





$("#guardarALTA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioALTA'))

    if (formularioValido) {

    if (ID_FORMULARIO_ALTA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarALTA')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_ALTA = data.alta.ID_FORMULARIO_ALTA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                    
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarALTA')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_ALTA = data.alta.ID_FORMULARIO_ALTA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});






document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botoncuentas');
    
    botonAgregarContacto.removeEventListener('click', agregarReferencias); // Remover cualquier evento previo
    botonAgregarContacto.addEventListener('click', agregarReferencias);

    function agregarReferencias() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generareferencias', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-4 mb-3">
                <label>Nombre del Banco *</label>
                <input type="text" class="form-control" name="NOMBRE_BANCO" required>
            </div>
            <div class="col-4 mb-3">
                <label>No. De Cuenta *</label>
                <input type="number" class="form-control" name="NUMERO_CUENTA" required>
            </div>
            <div class="col-4 mb-3">
                <label>Tipo *</label>
                <select class="form-control" name="TIPO_CUENTA" required>
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="1">Ahorros</option>
                    <option value="2">Empresarial</option>
                    <option value="3">Cheques</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>CLABE interbancaria *</label>
                <input type="number" class="form-control" name="CLABE_INTERBANCARIA" required>
            </div>
            <div class="col-6 mb-3">
                <label>Ciudad *</label>
                <input type="text" class="form-control" name="CIUDAD_CUENTA" required>
            </div>
            <div class="col-6 mb-3">
                <label>País *</label>
                <input type="text" class="form-control" name="PAIS_CUENTA" required>
            </div>
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar cuenta<i class="bi bi-trash-fill"></i></button>
            </div>
        `;

        const contenedor = document.querySelector('.cuentasdiv');
        contenedor.appendChild(divContacto);

        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    }
});







document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA_ALTA");
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");
    const labelRFC = document.querySelector('label[for="RFC_LABEL"]'); // Selecciona el label específico


    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";
            labelRFC.textContent = "R.F.C *";

        } else if (this.value === "2") {
            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";
            labelRFC.textContent = "Tax ID *";

        }
    });
});



document.addEventListener("DOMContentLoaded", function() {
    fetch('/obtener-datos-proveedor')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error);
            return;
        }

        document.getElementById("TIPO_PERSONA_ALTA").value = data.TIPO_PERSONA_ALTA;
        document.getElementById("RAZON_SOCIAL_ALTA").value = data.RAZON_SOCIAL_ALTA;
        document.getElementById("RFC_ALTA").value = data.RFC_ALTA;

        if (data.TIPO_PERSONA_ALTA == "1") {
            // Mostrar div de domicilio nacional
            document.querySelector('label[for="RFC_LABEL"]').textContent = "R.F.C";

            document.getElementById("DOMICILIO_NACIONAL").style.display = "block";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "none";

            document.getElementById("CODIGO_POSTAL").value = data.CODIGO_POSTAL;
            document.getElementById("TIPO_VIALIDAD_EMPRESA").value = data.TIPO_VIALIDAD_EMPRESA;
            document.getElementById("NOMBRE_VIALIDAD_EMPRESA").value = data.NOMBRE_VIALIDAD_EMPRESA;
            document.getElementById("NUMERO_EXTERIOR_EMPRESA").value = data.NUMERO_EXTERIOR_EMPRESA;
            document.getElementById("NUMERO_INTERIOR_EMPRESA").value = data.NUMERO_INTERIOR_EMPRESA;
            document.getElementById("NOMBRE_COLONIA_EMPRESA").value = data.NOMBRE_COLONIA_EMPRESA;
            document.getElementById("NOMBRE_LOCALIDAD_EMPRESA").value = data.NOMBRE_LOCALIDAD_EMPRESA;
            document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = data.NOMBRE_MUNICIPIO_EMPRESA;
            document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = data.NOMBRE_ENTIDAD_EMPRESA;
            document.getElementById("PAIS_EMPRESA").value = data.PAIS_EMPRESA;
            document.getElementById("ENTRE_CALLE_EMPRESA").value = data.ENTRE_CALLE_EMPRESA;
            document.getElementById("ENTRE_CALLE2_EMPRESA").value = data.ENTRE_CALLE2_EMPRESA;
        } else if (data.TIPO_PERSONA_ALTA == "2") {
            // Mostrar div de domicilio extranjero
            document.querySelector('label[for="RFC_LABEL"]').textContent = "Tax ID";

            document.getElementById("DOMICILIO_NACIONAL").style.display = "none";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "block";

            document.getElementById("DOMICILIO_EXTRANJERO").value = data.DOMICILIO_EXTRANJERO;
            document.getElementById("CODIGO_EXTRANJERO").value = data.CODIGO_EXTRANJERO;
            document.getElementById("CIUDAD_EXTRANJERO").value = data.CIUDAD_EXTRANJERO;
            document.getElementById("ESTADO_EXTRANJERO").value = data.ESTADO_EXTRANJERO;
            document.getElementById("PAIS_EXTRANJERO").value = data.PAIS_EXTRANJERO;
            document.getElementById("DEPARTAMENTO_EXTRANJERO").value = data.DEPARTAMENTO_EXTRANJERO;
        }
    })
    .catch(error => console.error('Error al obtener los datos:', error));
});