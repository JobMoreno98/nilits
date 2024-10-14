<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oficio de Asignación</title>

    <style>
        .col-md-6 {
            width: 50%;
            /* Ancho fijo para cada columna */
            float: left;
            /* Flota cada columna a la izquierda */
            box-sizing: border-box;
            /* Asegura que el padding y border estén incluidos en el ancho */
            text-align: center;
        }

        .clear-fix {
            clear: both;
            /* Asegura que no haya elementos flotantes después de estos elementos */
        }

        .col-md-6:first-child {
            /* Fondo azul para la primera columna */
            color: black;
            /* Texto blanco para la primera columna */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        .header,
        .footer {
            text-align: center;
        }

        .title {
            font-weight: bold;

        }

        .content {
            margin-top: 20px;
        }

        .text-right {
            text-align: right;
        }


        .signatures {
            text-align: center;
            /* Centra el contenido de '.signatures' */
            margin-top: 40px;
            /* Espacio por encima de las firmas */
        }

        .signatures p {
            display: inline-block;
            /* Mantiene los párrafos en línea */
            width: 40%;
            /* Margen horizontal para espaciar las firmas */
            vertical-align: top;
            /* Alinea los elementos al tope */
        }

        @page {
            margin-top: 15px;
            margin-bottom: 0px;
        }

        .page-break {
            page-break-after: avoid;
        }

        .footer .page:after {
            content: counter(page, decimal);
        }
    </style>
</head>

<body>
    <footer class="footer"
        style="position: fixed; bottom: 0; width: 100%; text-align: center; margin-top: auto; font-size: 10px">

        <p>Av. Los Belenes. Av. José Parres Arias #150, San José del Bajío, Zapopan, Jalisco, México</p>
        <p><span class="page">Página </span></p>
    </footer>
    <div class="header">
        <img src="{{ public_path('imgs/logo.png') }}" alt="Logo" style="height: 130px; width:100%">
    </div>

    <div class="container" style="margin-top: 5%">
        <p><strong>
                @if ($maestro->grado == 'Doctor')
                    Dr.
                @elseif ($maestro->grado == 'Doctora')
                    Dra.
                @elseif ($maestro->grado == 'Maestro')
                    Mtro.
                @elseif ($maestro->grado == 'Maestra')
                    Mtra.
                @endif {{ $maestro->Nombre }} {{ $maestro->Apellido }}
            </strong></p>
        <p>Tutor(a) del Programa Nivelación a la Licenciatura en Trabajo Social</p>
        <p>Presente</p>

        <p style="text-align: justify;">Por este medio, se hace constar la asignación oficial de <b>
                {{ count($tutorados) }}
                alumnos </b>que estarán bajo su tutoría en la modalidad no convencional a distancia a partir del ciclo
            2024 A, para ser atendidos durante
            toda la trayectoria escolar dentro del programa académico de la Nivelación a la Licenciatura en
            Trabajo Social (NiLiTS).</p>


        <table style="width: 100%; font-size:80%; margin-right: 10px; float: left;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Dictamen</th>
                    <th>Modalidad</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tutorados as $tutorado)
                    <tr style="font-size: 8pt;">
                        <td>{{ $tutorado->codigo }}</td>
                        <td style="text-transform:uppercase;">{{ $tutorado->Nombre }}</td>
                        <td>{{ explode(".",$tutorado->dictamen)[0] }}</td>
                        <td>No convecnional </td>
                        <td>{{ $tutorado->correo }}</td>
                    </tr>
                @endforeach


            </tbody>

        </table>

        <p style="text-align: jusitfy;">
            Favor de ponerse en contacto con los alumnos lo antes posible e iniciar las actividades correspondientes, de
            acuerdo con los lineamientos establecidos para la actividad tutorial señalados en el Reglamento del Programa
        </p>
        <p style="text-align: center;">
            Atentamente <br>
            <b>“Piensa y Trabaja” <br>“30 años de la Autonomía de la <br>
                Universidad de Guadalajara y de su organización en Red”</b> <br>Zapopan, Jalisco, {{ $fechaActual }}
        </p>
    </div>


    <div class="signatures">
        <p style="text-align: center;font-size: 10pt margin-top: 150px;">Dr. Ricardo Fletes Corona<br>Jefe del
            Departamento de
            Desarrollo Social</p>
        <p style="text-align: center;font-size: 10pt margin-top: 150px;">Mtra. María Rosas Moreno<br>Coordinadora de
            Carrera de la
            NiLiTS</p>
        <p style="text-align: center;font-size: 10pt;margin-top:70px;">Dra. Narali Esquivel Bautista<br>Responsable
            de Tutorías de la
            NiLiTS</p>
    </div>

    </div>

</body>

</html>
