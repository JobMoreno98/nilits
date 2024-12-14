<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Constancia</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            margin: 0px;
        }

        .header h1,
        .header h2 {
            text-align: center;
            font-weight: bold;
        }

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

        /* Estilos adicionales para la visualización de los textos */
        .col-md-6 p {
            margin: 0;
            /* Elimina el margen predeterminado de los párrafos */
            padding: 10px;
            /* Añade algo de padding para evitar que el texto toque los bordes del `div` */
        }

        .col-md-6:first-child {
            /* Fondo azul para la primera columna */
            color: black;
            /* Texto blanco para la primera columna */
        }

        .col-md-6:last-child {
            /* Fondo gris para la segunda columna */
            color: black;
            /* Texto negro para la segunda columna */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
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
            /* Ancho de cada firma */
            margin: 2 3.5%;
            /* Margen horizontal para espaciar las firmas */
            vertical-align: top;
            /* Alinea los elementos al tope */
            text-align: left;
            /* Alinea el texto a la izquierda dentro de cada firma */
        }

        @page {
            margin-top: 15px;
            margin-bottom: 0px;
        }

        .page-break {
            page-break-after: avoid;
        }
    </style>
</head>

<body>
    <div>
        <div class="header">
            <img src="{{ public_path('imgs/logo.png') }}" alt="Logo" style="width: 99%; height: auto; margin: 10px ">


        </div>



        <div class="content " style="margin-top: 5%">
            <div class="d-flex align-items-center justify-content-center text-center"
                style="height: 50vh; text-align: center;">
                <div>
                    <p style="font-size: 17px ">SE OTORGA LA PRESENTE</p>
                    <h3>CONSTANCIA</h3>
                    <p>A:</p>
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
                </div>
            </div>


            <p style="text-align: justify;">Por haber impartido tutoría académica y permanente de
                <b>{{ count($maestro->tutorados) }} alumnos</b>
                del
                Programa de
                Noviciado en la Licenciatura en Trabajo Social:</p>

            <div style=" width: 100%;">
                {{-- Primera mitad de tutorados --}}
                <table style="width: 100%; font-size:80%; margin-top: 5%; ">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maestro->tutorados as $tutorado)
                            <tr>
                                <td>{{ $tutorado->codigo }}</td>
                                <td>{{ $tutorado->Nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Segunda mitad de tutorados --}}

            </div>

            <p style="text-align: jusitfy;">
                Favor de ponerse en contacto con los alumnos lo antes posible e iniciar las actividades
                correspondientes, de
                acuerdo con los lineamientos establecidos para la actividad tutorial señalados en el Reglamento del
                Programa
            </p>
            <p style="text-align: center;">
                Atentamente <br>
                <b>“Piensa y Trabaja” <br>“30 años de la Autonomía de la <br>
                    Universidad de Guadalajara y de su organización en Red”</b> <br>Zapopan, Jalisco,
                {{ $fechaActual }}
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


    <div class="footer"
        style="position: fixed; bottom: 0; width: 100%; text-align: center; margin-top: 45%; font-size: 10px">

        <p>Av. de los Maestros y Alcalde, Edificio "N" 2da. planta, Col. La Normal</p>
        <p>Guadalajara, Jal., México</p>
    </div>
</body>

</html>
