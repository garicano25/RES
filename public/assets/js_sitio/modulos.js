
        function mostrarModal(imagen, titulo, descripcion) {
            const modal = document.getElementById('modalAnuncio');
            document.getElementById('modalImagen').src = imagen;
            document.getElementById('modalTitulo').innerText = titulo;
            document.getElementById('modalDescripcion').innerText = descripcion;
            modal.style.display = 'flex';

            // Cerrar si hace clic fuera del contenido
            modal.onclick = function() {
                cerrarModal();
            }
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
            iniciarCarrusel('carruselDiaAnio', 5000); // carrusel de anuncios del día/año
            iniciarCarrusel('carruselMes', 5000); // carrusel de anuncios del mes
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
   