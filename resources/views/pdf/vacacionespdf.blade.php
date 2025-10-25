<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PS-RH-FO-23 Solicitud de Vacaciones</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            font-weight: 400;
            src: url("{{ public_path('fonts/poppins/Poppins-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: 500;
            src: url("{{ public_path('fonts/poppins/Poppins-Medium.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: 600;
            src: url("{{ public_path('fonts/poppins/Poppins-SemiBold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        @page {
            size: letter landscape;
            margin: 145px 40px 40px 40px;
        }

        header {
            position: fixed;
            top: -95px;
            left: 0;
            right: 0;
            height: 120px;
        }

        main {
            margin-top: -10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
        }

        .tabla-borde {
            border-left: 1.5px solid black;
            border-right: 1.5px solid black;
        }

        .tabla-superior {
            border-top: 1.5px solid black;
        }

        .tabla-inferior {
            border-bottom: 1.5px solid black;
        }

        .bg-gray {
            background-color: #ccc;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 130px;
        }

        .tabla-encabezado td {
            border: 1px solid black;
        }

        .tabla-observaciones td {
            height: 60px;
            vertical-align: top;
        }

        /* === Encabezado nuevo, centrado y proporcional === */
        .header-tabla {
            border-collapse: collapse;
            width: 100%;
            border: 1.5px solid black;
        }

        .header-tabla td {
            border: 1px solid black;
            vertical-align: middle;
            padding: 4px;
        }

        .logo-col {
            width: 13%;
            text-align: center;
        }

        .titulo-col {
            text-align: center;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .info-col {
            width: 13%;
            font-size: 9.5px;
            text-align: center;
        }

        .info-col td {
            border: 1px solid black;
            padding: 2px;
        }
    </style>
</head>

<body> {{-- HEADER --}}
    <header>
        <table class="header-tabla">
            <tr>
                <td rowspan="3" class="logo-col"> <img src="{{ public_path('assets/images/Color@4x.png') }}" class="logo" style="margin-top: 12px;"> </td>
                <td rowspan="3" class="titulo-col"> <strong>Solicitud de Vacaciones</strong> </td>
                <td class="info-col bold">PS-RH-FO-23</td>
            </tr>
            <tr>
                <td class="info-col">Versión: 0</td>
            </tr>
            <tr>
                <td class="info-col">Página 1 de 1</td>
            </tr>
        </table>
    </header> {{-- CONTENIDO --}}
    <main> {{-- DATOS DEL EMPLEADO --}}
        <table class="tabla-borde" style="border-top: none;">
            <tr>
                <td class="bg-gray" colspan="2">Nombre de la Empresa:</td>
                <td colspan="4">Results In Performance S.A. de C.V.</td>
                <td class="bg-gray">Área o Departamento:</td>
                <td>{{ $empleado->AREA_VACACIONES ?? '' }}</td>
            </tr>
            <tr>
                <td class="bg-gray">No de Empleado:</td>
                <td>{{ $empleado->NOEMPLEADO_PERMISO_VACACIONES ?? '' }}</td>
                <td class="bg-gray">Nombre del Empleado:</td>
                <td colspan="5">{{ $empleado->SOLICITANTE_SALIDA ?? '' }}</td>
            </tr>
            <tr>
                <td class="bg-gray">Fecha de Ingreso:</td>
                <td>{{ $fecha_ingreso }}</td>
                <td class="bg-gray">Años de Servicio:</td>
                <td>{{ $empleado->ANIO_SERVICIO_VACACIONES ?? '' }} años</td>
                <td class="bg-gray">Días que Corresponden:</td>
                <td>{{ $empleado->DIAS_CORRESPONDEN_VACACIONES ?? '' }}</td>
                <td class="bg-gray">Días a Disfrutar:</td>
                <td>{{ $empleado->DIAS_DISFRUTAR_VACACIONES ?? '' }}</td>
            </tr>
            <tr>
                <td class="bg-gray">Días Pendientes:</td>
                <td>{{ $empleado->DIAS_PENDIENTES_VACACIONES ?? '' }}</td>
                <td class="bg-gray" colspan="2">Período a Disfrutar:</td>
                <td colspan="2">Desde Año {{ $empleado->DESDE_ANIO_VACACIONES ?? '' }}</td>
                <td colspan="2">Hasta el Año {{ $empleado->HASTA_ANIO_VACACIONES ?? '' }}</td>
            </tr>
        </table> {{-- DÍAS DE VACACIONES --}}
        <table class="tabla-borde" style="border-top: none;">
            <tr>
                <td class="bg-gray text-center" colspan="8">Días que Inician sus Vacaciones</td>
            </tr>
            <tr class="text-center">
                <td class="bg-gray">Del</td>
                <td>{{ $fecha_inicio->format('Y') }}</td>
                <td>{{ $fecha_inicio->format('m') }}</td>
                <td>{{ $fecha_inicio->format('d') }}</td>
                <td class="bg-gray">Al</td>
                <td>{{ $fecha_termino->format('Y') }}</td>
                <td>{{ $fecha_termino->format('m') }}</td>
                <td>{{ $fecha_termino->format('d') }}</td>
            </tr>
            <tr>
                <td class="bg-gray" colspan="4">Fecha en que deberá presentarse a trabajar:</td>
                <td colspan="4">{{ $fecha_presentacion }}</td>
            </tr>
        </table> {{-- OBSERVACIONES --}}
        <table class="tabla-borde tabla-observaciones" style="border-top: none;">
            <tr>
                <td class="bg-gray text-center bold">OBSERVACIONES</td>
            </tr>
            <tr>
                <td>{{ $empleado->OBSERVACIONES_REC ?? '' }}</td>
            </tr>
        </table> {{-- TEXTO LEGAL --}}
        <p style="margin-top: 10px; text-align: justify;"> Por el presente expreso mi conformidad de solicitar y gozar mis vacaciones de acuerdo con lo que establece el artículo 76 de la Ley Federal del Trabajo vigente, considerando los datos antes mencionados. </p> {{-- FECHA DE FIRMA --}}
        <table style="width: 100%; text-align: center;">
            <tr>
                <td>____________________</td>
                <td>{{ $dia_salida }}</td>
                <td>de</td>
                <td>{{ $mes_salida }}</td>
                <td>del</td>
                <td>{{ $anio_salida }}</td>
            </tr>
        </table> {{-- AUTORIZACIONES --}}
        <table class="tabla-borde tabla-inferior" style="margin-top: 15px;">
            <tr>
                <td colspan="3" class="text-center bg-gray bold">Autorizaciones</td>
            </tr>
            <tr class="text-center" style="height: 55px;">
                <td>________________________</td>
                <td>________________________</td>
                <td>________________________</td>
            </tr>
            <tr class="text-center bg-gray bold">
                <td>Solicita<br><span style="font-weight: normal;">Colaborador</span></td>
                <td>Vo. Bo.<br><span style="font-weight: normal;">Jefe inmediato</span></td>
                <td>Autoriza<br><span style="font-weight: normal;">Líder RRHH y Admón/Dirección</span></td>
            </tr>
        </table>
    </main>
</body>

</html>