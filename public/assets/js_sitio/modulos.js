
    

document.addEventListener("DOMContentLoaded", function() {
    setTimeout(() => {
        consultaotificaciones();
    }, 2000);
});



function mostrarModalDesdeData(element) {
            const imagen = element.getAttribute('data-imagen');
            const titulo = element.getAttribute('data-titulo');
            const descripcion = element.getAttribute('data-descripcion');

            document.getElementById('modalImagen').src = imagen;
            document.getElementById('modalTitulo').textContent = titulo;
            document.getElementById('modalDescripcion').textContent = descripcion;

            document.getElementById('modalAnuncio').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalAnuncio').style.display = 'none';
        }

        function cerrarModal() {
            document.getElementById('modalAnuncio').style.display = 'none';
        }


        function iniciarCarrusel(id, intervalo = 5000) {
            const carrusel = document.getElementById(id);
            if (!carrusel) return;

            const slides = carrusel.querySelectorAll('.carrusel-slide');
            let indice = 0;

            setInterval(() => {
                slides[indice].classList.remove('activo');
                indice = (indice + 1) % slides.length;
                slides[indice].classList.add('activo');
            }, intervalo);
        }

        document.addEventListener('DOMContentLoaded', function() {
            iniciarCarrusel('carruselDiaAnio', 5000); 
            iniciarCarrusel('carruselMes', 5000); 
        });

        document.getElementById('logoutButton').addEventListener('click', function(e) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas cerrar sesión?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
   

  
    const btnNoti = document.getElementById('btnNotificaciones');
    const panelNoti = document.getElementById('panelNotificaciones');

        btnNoti.addEventListener('click', () => {
            panelNoti.style.display = panelNoti.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (e) {
            if (!btnNoti.contains(e.target) && !panelNoti.contains(e.target)) {
                panelNoti.style.display = 'none';
            }
        });


function consultaotificaciones() {

    fetch('/notificaciones')
        .then(response => response.json())
        .then(data => {

            const cuerpo = document.querySelector('#panelNotificaciones .notification-body');
            cuerpo.innerHTML = "";

            if (!data || data.total === 0) {
                cuerpo.innerHTML = `
                    <p class="notification-item">📌 No tienes notificaciones por el momento.</p>
                `;
                return;
            }

          data.notificaciones.forEach(n => {
                cuerpo.innerHTML += `
                    <div class="notification-item" 
                        style="cursor:pointer; position:relative;" 
                        onclick="window.open('${n.link}', '_blank')">

                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong>${n.titulo}</strong>
                            ${n.estatus_badge} <!-- 🔥 badge directo del backend -->
                        </div>

                        <small>${n.detalle}</small><br>
                        <small>${n.fecha}</small>
                    </div>
                `;
            });

        })
        .catch(error => {
            console.error("Error cargando notificaciones:", error);
        });
}




