@extends('layouts.layout')

@section('title', 'Tutorados')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-light p-1 px-3" style="border-radius: 0px 10px;background-color: rgb(82, 82, 255)">Gestión de
        tutorados</h2>
    <table class="table table-striped" id="example">
        <thead class="thead-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estatus</th>
                <th>Último Dictamen</th>
                <th>Datos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->codigo }}</td>
                <td>{{ $alumno->Nombre }}</td>
                <td>{{ $alumno->correo }}</td>
                <td>
                    @if ($alumno->estatus == 1)
                    Activo
                    @elseif ($alumno->estatus == 3)
                    Egresado
                    @elseif ($alumno->estatus == 4)
                    Baja
                    @else
                    Otro
                    @endif
                </td>
                <td>
                    @php
                    $dictamenes = explode('.', $alumno->dictamen);
                    natsort($dictamenes);
                    $dictamenActual = end($dictamenes);
                    @endphp
                    {{ $dictamenActual }}
                </td>
                <td>
                    <a href="{{ route('alumnos.show', $alumno->id) }}"><i class="fas fa-edit edit-alumno-btn"
                            role="button"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 " id="staticBackdropLabel">Bienvenido</h1>
                
            </div>
            <div class="modal-body" style="text-align:justify" >
                La Universidad de Guadalajara (en adelante UdeG), con domicilio en Avenida Juárez 976, colonia Centro, código postal 44100, en Guadalajara, Jalisco, hace de su conocimiento que se considerará como información confidencial aquella que se encuentre
                contemplada en los artículos 3, fracciones IX y X de la LPDPPSOEJM; 21 de la LTAIPEJM; Lineamientos Cuadragésimo Octavo y Cuadragésimo Noveno de los Lineamientos de Clasificación; Lineamientos Décimo Sexto, Décimo Séptimo y Quincuagésimo Octavo de los Lineamientos de Protección, así como aquellos datos de una persona física identificada o identificable y la inherente a las personas jurídicas, los cuales podrán ser sometidos a tratamiento y serán única y exclusivamente utilizados para los fines que fueron proporcionados, de acuerdo con las finalidades y atribuciones establecidas en los artículos 1, 5 y 6 de la Ley Orgánica, así como 2 y 3 del Estatuto General, ambas legislaciones de la UdeG, de igual forma, para la prestación de los servicios que la misma ofrece conforme a las facultades y prerrogativas de la entidad universitaria correspondiente y estarán a resguardo y protección de la misma.

                Usted puede consultar nuestro Aviso de Privacidad integral en la siguiente página web:
                <a href="http://www.transparencia.udg.mx/aviso-confidencialidad-integral" target="_blank" rel="noopener noreferrer">
                    http://www.transparencia.udg.mx/aviso-confidencialidad-integral
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Acepto</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalEl = document.getElementById('staticBackdrop');
        if (typeof bootstrap !== 'undefined' && modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        } else {
            console.error("Bootstrap no está disponible o no se encontró el modal.");
        }
    });
</script>
<script>
    new DataTable('#example', {
        "pageLength": 10,
        "order": [
            [0, "asc"]
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        responsive: true,
        // dom: 'Bfrtip',
        dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'Alumnos con tutor',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Alumnos con tutor',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            }
        ]
    });
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "portugues-pre": function(data) {
            var a = 'a';
            var e = 'e';
            var i = 'i';
            var o = 'o';
            var u = 'u';
            var c = 'c';
            var special_letters = {
                "Á": a,
                "á": a,
                "Ã": a,
                "ã": a,
                "À": a,
                "à": a,
                "É": e,
                "é": e,
                "Ê": e,
                "ê": e,
                "Í": i,
                "í": i,
                "Î": i,
                "î": i,
                "Ó": o,
                "ó": o,
                "Õ": o,
                "õ": o,
                "Ô": o,
                "ô": o,
                "Ú": u,
                "ú": u,
                "Ü": u,
                "ü": u,
                "ç": c,
                "Ç": c
            };
            for (var val in special_letters)
                data = data.split(val).join(special_letters[val]).toLowerCase();
            return data;
        },
        "portugues-asc": function(a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "portugues-desc": function(a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
</script>
@endsection