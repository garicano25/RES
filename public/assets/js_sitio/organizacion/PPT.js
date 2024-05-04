document.addEventListener("DOMContentLoaded", function() {
    var abrir1ModalBtn = document.getElementById("abrirModalBtn");

    abrir1ModalBtn.addEventListener("click", function() {
        var modal = document.getElementById("exampleModal_PPT");
        var modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

   
});





