//VARIABLES
ID_FORMULARIO_PPT = 0


$("#guardarFormPPT").click(function (e) {
    e.preventDefault();

    if (ID_FORMULARIO_PPT == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se usara para la creación del PPT",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del PPT')

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información del PPT",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success','Información editada correctamente', 'Información guardada')
                    

                }, 300);  
            })
        }, 1)
    }
    
});