<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <p>{{ $saludo }} proveedor,</p>

    <p>Gracias por su pre-registro en nuestro ERP.</p>

    <p>Para concluir su registro, agradezco su apoyo para ingresar al siguiente link:</p>

    <p><a href="https://results-erp.results-in-performance.com/login">https://results-erp.results-in-performance.com/login</a></p>

    <p>Su clave para el acceso es la siguiente:</p>

    <ul>
        <li><strong>Usuario:</strong> {{ $usuario }}</li>
        <li><strong>Contraseña:</strong> {{ $contrasena }}</li>
    </ul>

    <p><strong>Notas:</strong></p>
    <p>
        <li>1.Tener en cuenta que al acceder les va solicitar un Código de Verificación, el cual llegará al correo que dieron de alta como contacto.</li>
        <li>2.Por favor completar el formulario en Datos generales, Actividad económica y términos comerciales e Información adicional para la debida diligencia.</li>
        <li>3.Y por último ingresar a cada Menú que se encuentra del lado izquierdo de su pantalla, completar y adjuntar los datos y documentos que solicita.</li>
    </p>

    <br>

    <p>Saludos cordiales.</p>
</body>

</html>