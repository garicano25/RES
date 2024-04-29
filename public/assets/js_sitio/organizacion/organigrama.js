

// MODAL DE AREA 
document.addEventListener("DOMContentLoaded", function() {
    var abrirModalBtn = document.getElementById("abrirModalBtn");

    abrirModalBtn.addEventListener("click", function() {
          var modal = document.getElementById("exampleModal_area");
      var modalInstance = new bootstrap.Modal(modal);
      modalInstance.show();
    });
  });




//  MODAL DEPARTAMENTO 
  document.addEventListener("DOMContentLoaded", function() {
    var abrir1ModalBtn = document.getElementById("abrir1ModalBtn");

    abrir1ModalBtn.addEventListener("click", function() {
          var modal = document.getElementById("exampleModal_departamento");
      var modalInstance = new bootstrap.Modal(modal);
      modalInstance.show();
    });
  });
