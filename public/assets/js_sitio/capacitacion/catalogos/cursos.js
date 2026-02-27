
ID_CURSOS_CAPACITACION = 0


const Modalcurso = document.getElementById('miModal_curso');
Modalcurso.addEventListener('hidden.bs.modal', event => {

    ID_CURSOS_CAPACITACION = 0;
    document.getElementById('formulariocurso').reset();

    $('#CADA_ANIO').hide();

    
});




$("#NUEVO_CURSO").click(function (e) {
    e.preventDefault();

       
    if ($('#CATEGORIAS_CURSO')[0].selectize) {
        $('#CATEGORIAS_CURSO')[0].selectize.destroy();
    }

    if ($('#TIPO_CURSO')[0].selectize) {
        $('#TIPO_CURSO')[0].selectize.destroy();
    }

    if ($('#AREA_CONOCIMIENTO')[0].selectize) {
        $('#AREA_CONOCIMIENTO')[0].selectize.destroy();
    }

    if ($('#NIVELES_CURSO')[0].selectize) {
        $('#NIVELES_CURSO')[0].selectize.destroy();
    }

    if ($('#MODALIDAD_CURSO')[0].selectize) {
        $('#MODALIDAD_CURSO')[0].selectize.destroy();
    }

    if ($('#FORMATO_CURSO')[0].selectize) {
        $('#FORMATO_CURSO')[0].selectize.destroy();
    }

    if ($('#PAISREGION_CURSO')[0].selectize) {
        $('#PAISREGION_CURSO')[0].selectize.destroy();
    }

    if ($('#IDIOMAS_CURSO')[0].selectize) {
        $('#IDIOMAS_CURSO')[0].selectize.destroy();
    }
    
    if ($('#NORMATIVA_CURSO')[0].selectize) {
        $('#NORMATIVA_CURSO')[0].selectize.destroy();
    }

    if ($('#RECONOCIMIENTO_CURSO')[0].selectize) {
        $('#RECONOCIMIENTO_CURSO')[0].selectize.destroy();
    }
    
    if ($('#COMPETENCIAS_CURSO')[0].selectize) {
        $('#COMPETENCIAS_CURSO')[0].selectize.destroy();
    }
    
    if ($('#TIPO_PROVEEDOR')[0].selectize) {
        $('#TIPO_PROVEEDOR')[0].selectize.destroy();
    }

    if ($('#METODO_EVALUACION')[0].selectize) {
        $('#METODO_EVALUACION')[0].selectize.destroy();
    }

    if ($('#EVIDENCIAS_GENERADAS')[0].selectize) {
        $('#EVIDENCIAS_GENERADAS')[0].selectize.destroy();
    }

    if ($('#DOCUMENTOS_EMITIDOS')[0].selectize) {
        $('#DOCUMENTOS_EMITIDOS')[0].selectize.destroy();
    }

    if ($('#UBICACION_CURSO')[0].selectize) {
        $('#UBICACION_CURSO')[0].selectize.destroy();
    }

    if ($('#MATERIAL_DIDACTICO')[0].selectize) {
        $('#MATERIAL_DIDACTICO')[0].selectize.destroy();
    }

    if ($('#IMPACTO_ESPERADO')[0].selectize) {
        $('#IMPACTO_ESPERADO')[0].selectize.destroy();
    }

    
    $('#formularioRECURSOSEMPLEADO').each(function () {
        this.reset();
    });


    $("#miModal_curso").modal("show");
   
  
   $('#CATEGORIAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
   });
    
    $('#TIPO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
  
    $('#AREA_CONOCIMIENTO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
 
    $('#NIVELES_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#MODALIDAD_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
    
    $('#FORMATO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#PAISREGION_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#IDIOMAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#NORMATIVA_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#RECONOCIMIENTO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#COMPETENCIAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#TIPO_PROVEEDOR').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#METODO_EVALUACION').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#EVIDENCIAS_GENERADAS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#DOCUMENTOS_EMITIDOS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#UBICACION_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#MATERIAL_DIDACTICO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

     $('#IMPACTO_ESPERADO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
});


$('#VIGENCIA_CURSO').on('change', function () {

    let valor = $(this).val();

    if (valor === "2" || valor === "3") {
        $('#CADA_ANIO').slideDown();
    } else {
        $('#CADA_ANIO').slideUp();
    }

});



$("#guardarcursos").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariocurso'))

    if (formularioValido) {

    if (ID_CURSOS_CAPACITACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcursos')
            await ajaxAwaitFormData({ api: 1, ID_CURSOS_CAPACITACION: ID_CURSOS_CAPACITACION }, 'CapCursoSave', 'formulariocurso', 'guardarcursos', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CURSOS_CAPACITACION = data.capacitaciones.ID_CURSOS_CAPACITACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_curso').modal('hide')
                    document.getElementById('formulariocurso').reset();
                    Tablacapcursos.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcursos')
            await ajaxAwaitFormData({ api: 1, ID_CURSOS_CAPACITACION: ID_CURSOS_CAPACITACION }, 'CapCursoSave', 'formulariocurso', 'guardarcursos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CURSOS_CAPACITACION = data.capacitaciones.ID_CURSOS_CAPACITACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_curso').modal('hide')
                    document.getElementById('formulariocurso').reset();
                    Tablacapcursos.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapcursos = $("#Tablacapcursos").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
    info: false,
    paging: true,
    searching: true,
    filtering: true,
    scrollY: '65vh',
    scrollCollapse: true,
    responsive: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablacapcursos',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapcursos.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], 
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NUMERO_ID' },
        { data: 'NOMBE_OFICIAL_CURSO' },
        { data: 'NOMBE_COMERCIAL_CURSO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Código del curso', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre oficial del curso', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Nombre corto / comercial', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapcursos tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcursos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CURSOS_CAPACITACION: row.data().ID_CURSOS_CAPACITACION
    };

    eliminarDatoTabla(data, [Tablacapcursos], 'CapCursoDelete');
});



$('#Tablacapcursos tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcursos.row(tr);


    ID_CURSOS_CAPACITACION = row.data().ID_CURSOS_CAPACITACION;

    editarDatoTabla(row.data(), 'formulariocurso', 'miModal_curso',1);



    if (row.data().VIGENCIA_CURSO === "1") {
        $('#CADA_ANIO').hide();
    } else if (row.data().VIGENCIA_CURSO === "2") {
        $('#CADA_ANIO').show();
    } else if (row.data().VIGENCIA_CURSO === "3") {
        $('#CADA_ANIO').show();
    }else {
        $('#CADA_ANIO').hide();
    }


    /// CATEGORIAS 
    if (!$('#CATEGORIAS_CURSO')[0].selectize) {
            $('#CATEGORIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcat = $('#CATEGORIAS_CURSO')[0].selectize;
        selcat.clear();

        let valorescat = row.data().CATEGORIAS_CURSO;

        if (typeof valorescat === "string") {
            try { valorescat = JSON.parse(valorescat); } catch (e) { valorescat = []; }
        }

        if (Array.isArray(valorescat)) {
            selcat.setValue(valorescat);
    }
    

    /// TIPO CURSO
    if (!$('#TIPO_CURSO')[0].selectize) {
            $('#TIPO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipocurso = $('#TIPO_CURSO')[0].selectize;
        seltipocurso.clear();

        let valorestipocurso= row.data().TIPO_CURSO;

        if (typeof valorestipocurso === "string") {
            try { valorestipocurso = JSON.parse(valorestipocurso); } catch (e) { valorestipocurso = []; }
        }

        if (Array.isArray(valorestipocurso)) {
            seltipocurso.setValue(valorestipocurso);
    }

    /// AREA CONOCIMIENTO
    if (!$('#AREA_CONOCIMIENTO')[0].selectize) {
            $('#AREA_CONOCIMIENTO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selarea = $('#AREA_CONOCIMIENTO')[0].selectize;
        selarea.clear();

        let valoresarea= row.data().AREA_CONOCIMIENTO;

        if (typeof valoresarea === "string") {
            try { valoresarea = JSON.parse(valoresarea); } catch (e) { valoresarea = []; }
        }

        if (Array.isArray(valoresarea)) {
            selarea.setValue(valoresarea);
    }

     /// NIVELES
    if (!$('#NIVELES_CURSO')[0].selectize) {
            $('#NIVELES_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selniveles = $('#NIVELES_CURSO')[0].selectize;
        selniveles.clear();

        let valorniveles= row.data().NIVELES_CURSO;

        if (typeof valorniveles === "string") {
            try { valorniveles = JSON.parse(valorniveles); } catch (e) { valorniveles = []; }
        }

        if (Array.isArray(valorniveles)) {
            selniveles.setValue(valorniveles);
    }

     /// MODALIDAD
    if (!$('#MODALIDAD_CURSO')[0].selectize) {
            $('#MODALIDAD_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmodalidad = $('#MODALIDAD_CURSO')[0].selectize;
        selmodalidad.clear();

        let valormodalidad= row.data().MODALIDAD_CURSO;

        if (typeof valormodalidad === "string") {
            try { valormodalidad = JSON.parse(valormodalidad); } catch (e) { valormodalidad = []; }
        }

        if (Array.isArray(valormodalidad)) {
            selmodalidad.setValue(valormodalidad);
    }

    /// FORMATO
    if (!$('#FORMATO_CURSO')[0].selectize) {
            $('#FORMATO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selformato = $('#FORMATO_CURSO')[0].selectize;
        selformato.clear();

        let valorformato= row.data().FORMATO_CURSO;

        if (typeof valorformato === "string") {
            try { valorformato = JSON.parse(valorformato); } catch (e) { valorformato = []; }
        }

        if (Array.isArray(valorformato)) {
            selformato.setValue(valorformato);
    }

     /// PAIS
    if (!$('#PAISREGION_CURSO')[0].selectize) {
            $('#PAISREGION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selpais = $('#PAISREGION_CURSO')[0].selectize;
        selpais.clear();

        let valorpais= row.data().PAISREGION_CURSO;

        if (typeof valorpais === "string") {
            try { valorpais = JSON.parse(valorpais); } catch (e) { valorpais = []; }
        }

        if (Array.isArray(valorpais)) {
            selpais.setValue(valorpais);
    }

      /// IDIOMA
    if (!$('#IDIOMAS_CURSO')[0].selectize) {
            $('#IDIOMAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selidioma = $('#IDIOMAS_CURSO')[0].selectize;
        selidioma.clear();

        let valoridioma= row.data().IDIOMAS_CURSO;

        if (typeof valoridioma === "string") {
            try { valoridioma = JSON.parse(valoridioma); } catch (e) { valoridioma = []; }
        }

        if (Array.isArray(valoridioma)) {
            selidioma.setValue(valoridioma);
    }

       /// NORMATIVA
    if (!$('#NORMATIVA_CURSO')[0].selectize) {
            $('#NORMATIVA_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selnormativa = $('#NORMATIVA_CURSO')[0].selectize;
        selnormativa.clear();

        let valornormativa= row.data().NORMATIVA_CURSO;

        if (typeof valornormativa === "string") {
            try { valornormativa = JSON.parse(valornormativa); } catch (e) { valornormativa = []; }
        }

        if (Array.isArray(valornormativa)) {
            selnormativa.setValue(valornormativa);
    }

      /// RECONOCIMIENTO
    if (!$('#RECONOCIMIENTO_CURSO')[0].selectize) {
            $('#RECONOCIMIENTO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selreconocimiento = $('#RECONOCIMIENTO_CURSO')[0].selectize;
        selreconocimiento.clear();

        let valoreconocimineto= row.data().RECONOCIMIENTO_CURSO;

        if (typeof valoreconocimineto === "string") {
            try { valoreconocimineto = JSON.parse(valoreconocimineto); } catch (e) { valoreconocimineto = []; }
        }

        if (Array.isArray(valoreconocimineto)) {
            selreconocimiento.setValue(valoreconocimineto);
    }

      /// COMPETENCIAS
    if (!$('#COMPETENCIAS_CURSO')[0].selectize) {
            $('#COMPETENCIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcompetencias = $('#COMPETENCIAS_CURSO')[0].selectize;
        selcompetencias.clear();

        let valorcompetencias= row.data().COMPETENCIAS_CURSO;

        if (typeof valorcompetencias === "string") {
            try { valorcompetencias = JSON.parse(valorcompetencias); } catch (e) { valorcompetencias = []; }
        }

        if (Array.isArray(valorcompetencias)) {
            selcompetencias.setValue(valorcompetencias);
    }

     /// TIPO PROVEEDOR
    if (!$('#TIPO_PROVEEDOR')[0].selectize) {
            $('#TIPO_PROVEEDOR').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipoproveedor = $('#TIPO_PROVEEDOR')[0].selectize;
        seltipoproveedor.clear();

        let valortipoproveedor= row.data().TIPO_PROVEEDOR;

        if (typeof valortipoproveedor === "string") {
            try { valortipoproveedor = JSON.parse(valortipoproveedor); } catch (e) { valortipoproveedor = []; }
        }

        if (Array.isArray(valortipoproveedor)) {
            seltipoproveedor.setValue(valortipoproveedor);
    }

     ///  METODO EVALUACION
    if (!$('#METODO_EVALUACION')[0].selectize) {
            $('#METODO_EVALUACION').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmetodoevaluacion = $('#METODO_EVALUACION')[0].selectize;
        selmetodoevaluacion.clear();

        let valormetodoevaluacion= row.data().METODO_EVALUACION;

        if (typeof valormetodoevaluacion === "string") {
            try { valormetodoevaluacion = JSON.parse(valormetodoevaluacion); } catch (e) { valormetodoevaluacion = []; }
        }

        if (Array.isArray(valormetodoevaluacion)) {
            selmetodoevaluacion.setValue(valormetodoevaluacion);
    }

      ///  EVIDENCIAS GENERADAS
    if (!$('#EVIDENCIAS_GENERADAS')[0].selectize) {
            $('#EVIDENCIAS_GENERADAS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selevidencias = $('#EVIDENCIAS_GENERADAS')[0].selectize;
        selevidencias.clear();

        let valorevidencias= row.data().EVIDENCIAS_GENERADAS;

        if (typeof valorevidencias === "string") {
            try { valorevidencias = JSON.parse(valorevidencias); } catch (e) { valorevidencias = []; }
        }

        if (Array.isArray(valorevidencias)) {
            selevidencias.setValue(valorevidencias);
    }

        ///  DOCUMENTOS EMITIDOS
    if (!$('#DOCUMENTOS_EMITIDOS')[0].selectize) {
            $('#DOCUMENTOS_EMITIDOS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seldocumentos= $('#DOCUMENTOS_EMITIDOS')[0].selectize;
        seldocumentos.clear();

        let valordocumentos= row.data().DOCUMENTOS_EMITIDOS;

        if (typeof valordocumentos === "string") {
            try { valordocumentos = JSON.parse(valordocumentos); } catch (e) { valordocumentos = []; }
        }

        if (Array.isArray(valordocumentos)) {
            seldocumentos.setValue(valordocumentos);
    }

       ///  UBICACION   
    if (!$('#UBICACION_CURSO')[0].selectize) {
            $('#UBICACION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selubicacion= $('#UBICACION_CURSO')[0].selectize;
        selubicacion.clear();

        let valorubicacion= row.data().UBICACION_CURSO;

        if (typeof valorubicacion === "string") {
            try { valorubicacion = JSON.parse(valorubicacion); } catch (e) { valorubicacion = []; }
        }

        if (Array.isArray(valorubicacion)) {
            selubicacion.setValue(valorubicacion);
    }

     ///  MATERIAL DIDACTICO   
    if (!$('#MATERIAL_DIDACTICO')[0].selectize) {
            $('#MATERIAL_DIDACTICO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmaterial= $('#MATERIAL_DIDACTICO')[0].selectize;
        selmaterial.clear();

        let valormaterial= row.data().MATERIAL_DIDACTICO;

        if (typeof valormaterial === "string") {
            try { valormaterial = JSON.parse(valormaterial); } catch (e) { valormaterial = []; }
        }

        if (Array.isArray(valormaterial)) {
            selmaterial.setValue(valormaterial);
    }

     /// IMPACTO ESPERADO   
    if (!$('#IMPACTO_ESPERADO')[0].selectize) {
            $('#IMPACTO_ESPERADO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selimpacto= $('#IMPACTO_ESPERADO')[0].selectize;
        selimpacto.clear();

        let valorimpacto= row.data().IMPACTO_ESPERADO;

        if (typeof valorimpacto === "string") {
            try { valorimpacto = JSON.parse(valorimpacto); } catch (e) { valorimpacto = []; }
        }

        if (Array.isArray(valorimpacto)) {
            selimpacto.setValue(valorimpacto);
    }





    $('#miModal_curso .modal-title').html(row.data().NOMBE_OFICIAL_CURSO);

});



$(document).ready(function() {
    $('#Tablacapcursos tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapcursos.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_curso');

        ID_CURSOS_CAPACITACION = row.data().ID_CURSOS_CAPACITACION;
        editarDatoTabla(row.data(), 'formulariocurso', 'miModal_curso',1);



    if (row.data().VIGENCIA_CURSO === "1") {
        $('#CADA_ANIO').hide();
    } else if (row.data().VIGENCIA_CURSO === "2") {
        $('#CADA_ANIO').show();
    } else if (row.data().VIGENCIA_CURSO === "3") {
        $('#CADA_ANIO').show();
    }else {
        $('#CADA_ANIO').hide();
    }


    /// CATEGORIAS 
    if (!$('#CATEGORIAS_CURSO')[0].selectize) {
            $('#CATEGORIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcat = $('#CATEGORIAS_CURSO')[0].selectize;
        selcat.clear();

        let valorescat = row.data().CATEGORIAS_CURSO;

        if (typeof valorescat === "string") {
            try { valorescat = JSON.parse(valorescat); } catch (e) { valorescat = []; }
        }

        if (Array.isArray(valorescat)) {
            selcat.setValue(valorescat);
    }
    

    /// TIPO CURSO
    if (!$('#TIPO_CURSO')[0].selectize) {
            $('#TIPO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipocurso = $('#TIPO_CURSO')[0].selectize;
        seltipocurso.clear();

        let valorestipocurso= row.data().TIPO_CURSO;

        if (typeof valorestipocurso === "string") {
            try { valorestipocurso = JSON.parse(valorestipocurso); } catch (e) { valorestipocurso = []; }
        }

        if (Array.isArray(valorestipocurso)) {
            seltipocurso.setValue(valorestipocurso);
    }

    /// AREA CONOCIMIENTO
    if (!$('#AREA_CONOCIMIENTO')[0].selectize) {
            $('#AREA_CONOCIMIENTO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selarea = $('#AREA_CONOCIMIENTO')[0].selectize;
        selarea.clear();

        let valoresarea= row.data().AREA_CONOCIMIENTO;

        if (typeof valoresarea === "string") {
            try { valoresarea = JSON.parse(valoresarea); } catch (e) { valoresarea = []; }
        }

        if (Array.isArray(valoresarea)) {
            selarea.setValue(valoresarea);
    }

     /// NIVELES
    if (!$('#NIVELES_CURSO')[0].selectize) {
            $('#NIVELES_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selniveles = $('#NIVELES_CURSO')[0].selectize;
        selniveles.clear();

        let valorniveles= row.data().NIVELES_CURSO;

        if (typeof valorniveles === "string") {
            try { valorniveles = JSON.parse(valorniveles); } catch (e) { valorniveles = []; }
        }

        if (Array.isArray(valorniveles)) {
            selniveles.setValue(valorniveles);
    }

     /// MODALIDAD
    if (!$('#MODALIDAD_CURSO')[0].selectize) {
            $('#MODALIDAD_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmodalidad = $('#MODALIDAD_CURSO')[0].selectize;
        selmodalidad.clear();

        let valormodalidad= row.data().MODALIDAD_CURSO;

        if (typeof valormodalidad === "string") {
            try { valormodalidad = JSON.parse(valormodalidad); } catch (e) { valormodalidad = []; }
        }

        if (Array.isArray(valormodalidad)) {
            selmodalidad.setValue(valormodalidad);
    }

    /// FORMATO
    if (!$('#FORMATO_CURSO')[0].selectize) {
            $('#FORMATO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selformato = $('#FORMATO_CURSO')[0].selectize;
        selformato.clear();

        let valorformato= row.data().FORMATO_CURSO;

        if (typeof valorformato === "string") {
            try { valorformato = JSON.parse(valorformato); } catch (e) { valorformato = []; }
        }

        if (Array.isArray(valorformato)) {
            selformato.setValue(valorformato);
    }

     /// PAIS
    if (!$('#PAISREGION_CURSO')[0].selectize) {
            $('#PAISREGION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selpais = $('#PAISREGION_CURSO')[0].selectize;
        selpais.clear();

        let valorpais= row.data().PAISREGION_CURSO;

        if (typeof valorpais === "string") {
            try { valorpais = JSON.parse(valorpais); } catch (e) { valorpais = []; }
        }

        if (Array.isArray(valorpais)) {
            selpais.setValue(valorpais);
    }

      /// IDIOMA
    if (!$('#IDIOMAS_CURSO')[0].selectize) {
            $('#IDIOMAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selidioma = $('#IDIOMAS_CURSO')[0].selectize;
        selidioma.clear();

        let valoridioma= row.data().IDIOMAS_CURSO;

        if (typeof valoridioma === "string") {
            try { valoridioma = JSON.parse(valoridioma); } catch (e) { valoridioma = []; }
        }

        if (Array.isArray(valoridioma)) {
            selidioma.setValue(valoridioma);
    }

       /// NORMATIVA
    if (!$('#NORMATIVA_CURSO')[0].selectize) {
            $('#NORMATIVA_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selnormativa = $('#NORMATIVA_CURSO')[0].selectize;
        selnormativa.clear();

        let valornormativa= row.data().NORMATIVA_CURSO;

        if (typeof valornormativa === "string") {
            try { valornormativa = JSON.parse(valornormativa); } catch (e) { valornormativa = []; }
        }

        if (Array.isArray(valornormativa)) {
            selnormativa.setValue(valornormativa);
    }

      /// RECONOCIMIENTO
    if (!$('#RECONOCIMIENTO_CURSO')[0].selectize) {
            $('#RECONOCIMIENTO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selreconocimiento = $('#RECONOCIMIENTO_CURSO')[0].selectize;
        selreconocimiento.clear();

        let valoreconocimineto= row.data().RECONOCIMIENTO_CURSO;

        if (typeof valoreconocimineto === "string") {
            try { valoreconocimineto = JSON.parse(valoreconocimineto); } catch (e) { valoreconocimineto = []; }
        }

        if (Array.isArray(valoreconocimineto)) {
            selreconocimiento.setValue(valoreconocimineto);
    }

      /// COMPETENCIAS
    if (!$('#COMPETENCIAS_CURSO')[0].selectize) {
            $('#COMPETENCIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcompetencias = $('#COMPETENCIAS_CURSO')[0].selectize;
        selcompetencias.clear();

        let valorcompetencias= row.data().COMPETENCIAS_CURSO;

        if (typeof valorcompetencias === "string") {
            try { valorcompetencias = JSON.parse(valorcompetencias); } catch (e) { valorcompetencias = []; }
        }

        if (Array.isArray(valorcompetencias)) {
            selcompetencias.setValue(valorcompetencias);
    }

     /// TIPO PROVEEDOR
    if (!$('#TIPO_PROVEEDOR')[0].selectize) {
            $('#TIPO_PROVEEDOR').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipoproveedor = $('#TIPO_PROVEEDOR')[0].selectize;
        seltipoproveedor.clear();

        let valortipoproveedor= row.data().TIPO_PROVEEDOR;

        if (typeof valortipoproveedor === "string") {
            try { valortipoproveedor = JSON.parse(valortipoproveedor); } catch (e) { valortipoproveedor = []; }
        }

        if (Array.isArray(valortipoproveedor)) {
            seltipoproveedor.setValue(valortipoproveedor);
    }

     ///  METODO EVALUACION
    if (!$('#METODO_EVALUACION')[0].selectize) {
            $('#METODO_EVALUACION').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmetodoevaluacion = $('#METODO_EVALUACION')[0].selectize;
        selmetodoevaluacion.clear();

        let valormetodoevaluacion= row.data().METODO_EVALUACION;

        if (typeof valormetodoevaluacion === "string") {
            try { valormetodoevaluacion = JSON.parse(valormetodoevaluacion); } catch (e) { valormetodoevaluacion = []; }
        }

        if (Array.isArray(valormetodoevaluacion)) {
            selmetodoevaluacion.setValue(valormetodoevaluacion);
    }

      ///  EVIDENCIAS GENERADAS
    if (!$('#EVIDENCIAS_GENERADAS')[0].selectize) {
            $('#EVIDENCIAS_GENERADAS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selevidencias = $('#EVIDENCIAS_GENERADAS')[0].selectize;
        selevidencias.clear();

        let valorevidencias= row.data().EVIDENCIAS_GENERADAS;

        if (typeof valorevidencias === "string") {
            try { valorevidencias = JSON.parse(valorevidencias); } catch (e) { valorevidencias = []; }
        }

        if (Array.isArray(valorevidencias)) {
            selevidencias.setValue(valorevidencias);
    }

        ///  DOCUMENTOS EMITIDOS
    if (!$('#DOCUMENTOS_EMITIDOS')[0].selectize) {
            $('#DOCUMENTOS_EMITIDOS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seldocumentos= $('#DOCUMENTOS_EMITIDOS')[0].selectize;
        seldocumentos.clear();

        let valordocumentos= row.data().DOCUMENTOS_EMITIDOS;

        if (typeof valordocumentos === "string") {
            try { valordocumentos = JSON.parse(valordocumentos); } catch (e) { valordocumentos = []; }
        }

        if (Array.isArray(valordocumentos)) {
            seldocumentos.setValue(valordocumentos);
    }

       ///  UBICACION   
    if (!$('#UBICACION_CURSO')[0].selectize) {
            $('#UBICACION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selubicacion= $('#UBICACION_CURSO')[0].selectize;
        selubicacion.clear();

        let valorubicacion= row.data().UBICACION_CURSO;

        if (typeof valorubicacion === "string") {
            try { valorubicacion = JSON.parse(valorubicacion); } catch (e) { valorubicacion = []; }
        }

        if (Array.isArray(valorubicacion)) {
            selubicacion.setValue(valorubicacion);
    }

     ///  MATERIAL DIDACTICO   
    if (!$('#MATERIAL_DIDACTICO')[0].selectize) {
            $('#MATERIAL_DIDACTICO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmaterial= $('#MATERIAL_DIDACTICO')[0].selectize;
        selmaterial.clear();

        let valormaterial= row.data().MATERIAL_DIDACTICO;

        if (typeof valormaterial === "string") {
            try { valormaterial = JSON.parse(valormaterial); } catch (e) { valormaterial = []; }
        }

        if (Array.isArray(valormaterial)) {
            selmaterial.setValue(valormaterial);
    }

     /// IMPACTO ESPERADO   
    if (!$('#IMPACTO_ESPERADO')[0].selectize) {
            $('#IMPACTO_ESPERADO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selimpacto= $('#IMPACTO_ESPERADO')[0].selectize;
        selimpacto.clear();

        let valorimpacto= row.data().IMPACTO_ESPERADO;

        if (typeof valorimpacto === "string") {
            try { valorimpacto = JSON.parse(valorimpacto); } catch (e) { valorimpacto = []; }
        }

        if (Array.isArray(valorimpacto)) {
            selimpacto.setValue(valorimpacto);
    }




         $('#miModal_curso .modal-title').html(row.data().NOMBE_OFICIAL_CURSO);

    });

    $('#miModal_curso').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_curso');
    });
});



$('#TIPO_ID').on('change', function () {

    let tipo = $(this).val();

    if (!tipo) {
        $('#NUMERO_ID').val('');
        return;
    }

    $.ajax({
        url: '/generarCodigoCurso',
        method: 'POST',
        data: {
            TIPO_ID: tipo,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            if (response.codigo) {
                $('#NUMERO_ID').val(response.codigo);
            } else {
                $('#NUMERO_ID').val('');
            }

        }
    });

});

