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
    text-align: center; /* Centra el contenido de '.signatures' */
    margin-top: 40px; /* Espacio por encima de las firmas */
}

.signatures p {
    display: inline-block; /* Mantiene los párrafos en línea */
    width: 40%; /* Ancho de cada firma */
    margin: 2 3.5%; /* Margen horizontal para espaciar las firmas */
    vertical-align: top; /* Alinea los elementos al tope */
    text-align: left; /* Alinea el texto a la izquierda dentro de cada firma */
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
    <div class="header">
        <img src="{{ public_path('imgs/logo.png') }}" alt="Logo" style="width: 99%; height: auto; margin: 10px " >


    </div>

    <div class="container" style="margin-top: 5%">
        <p><strong>@if ($maestro->grado  == 'Doctor')
            Dr.
        @elseif ($maestro->grado  == 'Doctora')
            Dra.
        @elseif ($maestro->grado  == 'Maestro')
            Mtro.
        @elseif ($maestro->grado  == 'Maestra')
            Mtra.
        @endif {{ $maestro->Nombre }} {{ $maestro->Apellido }}</strong></p>
        <p>Tutor(a) del Programa Nivelación a la Licenciatura en Trabajo Social</p>
        <p>Presente</p>

        <p style="text-align: justify;">Por este medio, se hace constar la asignación oficial de 20 alumnos que estarán bajo su tutoría
            en la modalidad no convencional a distancia a partir del ciclo 2024 A, para ser atendidos durante
            toda la trayectoria escolar dentro del programa académico de la Nivelación a la Licenciatura en
            Trabajo Social (NiLiTS).</p>


        <table class="" style="width: 100%; font-size:80%; margin-right: 10px; float: left;">
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
                    <tr>
                        <td>{{ $tutorado->codigo }}</td>
                        <td>{{ $tutorado->Nombre }}</td>
                        <td>{{ trim(str_replace('.', '', $tutorado->dictamen)) }}</td>
                        <td>{{ $tutorado->modalidad }}</td>
                        <td>{{ $tutorado->correo }}</td>
                    </tr>
                @endforeach


            </tbody>

        </table>

        <p style="text-align: center;" >Durante el ciclo escolar 2023 B, periodo comprendido del 16 julio de 2023 al 15 de enero de 2024, según consta en informe presentado en tiempo y forma.
            <p style="text-align: center;" >
        “Piensa y Trabaja” <br>“30 años de la Autonomía de la <br>
        Universidad de Guadalajara y de su organización en Red” <br>Guadalajara, Jal., a {{ $fechaActual }}</p>
    </div>
    <div class="signatures">
        <p>Dr. Ricardo Fletes Corona<br>Jefe del Departamento de Desarrollo Social</p>
        <p>Mtra. María Rosas Moreno<br>Coordinadora de Carrera de la NiLiTS</p>
        <p>Dra. Narali Esquivel Bautista<br>Coordinadora de Tutorías de la NiLiTS</p>
    </div>

    <div class="footer" style="position: fixed; bottom: 0; width: 100%; text-align: center; margin-top: 45%; font-size: 10px">

        <p>Av. de los Maestros y Alcalde, Edificio "N" 2da. planta, Col. La Normal</p>
        <p>Guadalajara, Jal., México</p>
    </div>

    </div>

</body>

</html>
