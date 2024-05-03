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
                                        <h5 class="modal-title">  Excel</h5>
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
    

    document.addEventListener('DOMContentLoaded', function() {
        const btnEliminar = document.querySelectorAll('.btn-eliminar');
    
        btnEliminar.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
    
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/delete/${id}`)
                            .then(response => {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Eliminado',
                                        text: 'El registro ha sido eliminado correctamente.',
                                        timer: 1000,
                                        showConfirmButton: false
                                    });
    
                                    // Recargar la página después de eliminar el registro
                                    window.location.reload();
                                } else {
                                    Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
                                console.error(error);
                            });
                    }
                });
            });
        });
    });
    