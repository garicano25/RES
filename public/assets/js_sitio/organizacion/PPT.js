document.addEventListener("DOMContentLoaded", function() {
    var abrir1ModalBtn = document.getElementById("abrirModalBtn");

    abrir1ModalBtn.addEventListener("click", function() {
        var modal = document.getElementById("exampleModal_PPT");
        var modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    if (sessionStorage.getItem('success')) {
        setTimeout(function() {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: sessionStorage.getItem('success'),
            });
            sessionStorage.removeItem('success'); // Limpiar la sesión después de mostrar la alerta
        }, 100); // Mostrar la alerta después de 100 milisegundos
    }
    
    // Mostrar alerta de error
    if (sessionStorage.getItem('error')) {
        setTimeout(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: sessionStorage.getItem('error'),
            });
            sessionStorage.removeItem('error'); // Limpiar la sesión después de mostrar la alerta
        }, 100); // Mostrar la alerta después de 100 milisegundos
    }
});



// $(document).ready(function() {
//     $('#tablaPPT').DataTable({
//         "processing": true,
//         "serverSide": false, 
//         "ajax": "{{ route('Datos_PPT') }}",
//         "columns": [
//             { "data": "ID_PPT" }, 
//             { "data": "NOMBRE_PUESTO" },
//             { "data": "ARCHIVO_PPT" },
//             {
//                 "data": null,
//                 "render": function(data, type, full, meta) {
//                     return '<button class="btn btn-primary btn-editar" data-id="' + data.id + '">Editar</button>';
//                 }
//             },
//             {
//                 "data": null,
//                 "render": function(data, type, full, meta) {
//                     return '<button class="btn btn-danger btn-eliminar" data-id="' + data.id + '">Eliminar</button>';
//                 }
//             }
//         ]
//     });
// });



    // document.addEventListener('DOMContentLoaded', function() {
    //     const visualizarButtons = document.querySelectorAll('.btn-visualizar');

    //     visualizarButtons.forEach(button => {
    //         button.addEventListener('click', function() {
    //             const fileUrl = this.getAttribute('data-file');

    //             // Usar SheetJS para leer y mostrar el archivo Excel
    //             fetch(fileUrl)
    //                 .then(res => res.arrayBuffer())
    //                 .then(buffer => {
    //                     const workbook = XLSX.read(buffer, { type: 'array' });
    //                     const sheetName = workbook.SheetNames[0];
    //                     const sheet = workbook.Sheets[sheetName];
    //                     const htmlTable = XLSX.utils.sheet_to_html(sheet);

    //                     // Crear un modal o elemento para mostrar la tabla HTML generada
    //                     const modalContent = `
    //                         <div class="modal-dialog modal-lg">
    //                             <div class="modal-content">
    //                                 <div class="modal-header">
    //                                     <h5 class="modal-title">Visualización de Excel</h5>
    //                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    //                                 </div>
    //                                 <div class="modal-body">
    //                                     ${htmlTable}
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     `;

    //                     const modal = document.createElement('div');
    //                     modal.classList.add('modal', 'fade');
    //                     modal.innerHTML = modalContent;
    //                     document.body.appendChild(modal);

    //                     // Mostrar el modal
    //                     const modalInstance = new bootstrap.Modal(modal);
    //                     modalInstance.show();
    //                 })
    //                 .catch(error => {
    //                     console.error('Error al cargar el archivo:', error);
    //                     alert('Error al cargar el archivo. Por favor, inténtalo de nuevo.');
    //                 });
    //         });
    //     });
    // });



    document.addEventListener('DOMContentLoaded', function() {
        const visualizarButtons = document.querySelectorAll('.btn-visualizar');
    
        visualizarButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fileUrl = this.getAttribute('data-file');
    
                fetch(fileUrl)
                    .then(res => res.arrayBuffer())
                    .then(buffer => {
                        const workbook = XLSX.read(buffer, { type: 'array' });
                        const sheetName = workbook.SheetNames[0];
                        const sheet = workbook.Sheets[sheetName];
                        const htmlTable = XLSX.utils.sheet_to_html(sheet);
    
                        // Crear un modal o elemento para mostrar la tabla HTML generada
                        const modalContent = `
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Visualización de Excel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ${htmlTable}
                                    </div>
                                </div>
                            </div>
                        `;
    
                        const modal = document.createElement('div');
                        modal.classList.add('modal', 'fade');
                        modal.innerHTML = modalContent;
                        document.body.appendChild(modal);
    
                        // Mostrar el modal
                        const modalInstance = new bootstrap.Modal(modal);
                        modalInstance.show();
                    })
                    .catch(error => {
                        console.error('Error al cargar el archivo:', error);
                        alert('Error al cargar el archivo. Por favor, inténtalo de nuevo.');
                    });
            });
        });
    });
    


// document.addEventListener('DOMContentLoaded', function() {
//     const form = document.getElementById('form-upload');

//     form.addEventListener('submit', function(e) {
//         e.preventDefault();

//         // Realizar la petición AJAX para guardar los datos
//         fetch('{{ route('upload.excel') }}', {
//             method: 'POST',
//             body: new FormData(form)
//         })
//         .then(response => response.json())
//         .then(data => {
//             // Mostrar SweetAlert2 al guardar los datos correctamente
//             Swal.fire({
//                 icon: 'success',
//                 title: '¡Datos guardados correctamente!',
//                 showConfirmButton: false,
//                 timer: 2000 // Duración en milisegundos (2 segundos)
//             });

//             // Aquí puedes hacer otras acciones, como limpiar el formulario, etc.
//         })
//         .catch(error => {
//             // Mostrar alerta de error en caso de problemas al guardar los datos
//             alert('Error al guardar los datos. Por favor, inténtalo de nuevo.');
//             console.error('Error:', error);
//         });
//     });
// });
