document.addEventListener("DOMContentLoaded", function() {
    var abrir1ModalBtn = document.getElementById("abrirModalBtn");

    abrir1ModalBtn.addEventListener("click", function() {
        var modal = document.getElementById("exampleModal_DPT");
        var modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

});





document.addEventListener('DOMContentLoaded', function() {
    const btnEliminar = document.querySelectorAll('.btn-eliminar_dpt');

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
                    axios.delete(`/eliminar/${id}`)
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
