@if (Auth::check())
    @extends('layouts/layout')

    @section('title', 'Gestión de Tutores')

    @section('content')
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="mb-0"> <img src="{{ asset('imgs/logo_NILITS23_color.png') }}" alt="Logo" style="width: 170px;">
                </h1>
                <form method="POST" class="btn btn-danger mt-3" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn text-light" type="submit">
                        Cerrar Sesión
                    </button>
                </form>
            </div>

            
            <h2 class="mb-4 text-light" style="background-color: rgb(82, 82, 255)">Normatividad</h2>

            <div class="d-flex justify-content-center">
                <div class="card m-2"  style="width: 18rem;">
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 190px; width: 285px;">
                    <div class="card-body">
                        <h5 class="card-title">Código de Conducta</h5>
                        <p class="card-text"> </p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/codigo-de-conducta-julio-2021.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2" style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 190px; width: 285px;">
                    <div class="card-body">
                        <h5 class="card-title">Reglamento de responsabilidades vinculadas con faltas a la normatividad universitaria de la UdeG</h5>
                        <p class="card-text"> </p>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/RRVFNU%20%28Junio%202022%29.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2" style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 190px; width: 285px;">
                    <div class="card-body">
                        <h5 class="card-title">Protocolo para la prevención, atención, sanción y erradicación de la violencia de género en la UdeG</h5>
                        <p class="card-text"> </p>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/PPASEVG%20%28Abril%202022%29.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>

            
            

            <br>
            <div>
                <h4 class="mb-4 text-light" style="background-color: rgba(82, 82, 255, 0.396)">Administrativa</h4>
            </div>
            <div class="d-flex justify-content-center">
                <div class="card m-2"  style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 180px; width: 250px;">
                    <div class="card-body">
                        <h5 class="card-title">Ley Orgánica de la UdeG</h5>
                        <p class="card-text"> </p>
                        <br>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/lo-septiembre-2021.pdf
                        " class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2" style="width: 18rem;">
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 180px; width: 250px;">
                    <div class="card-body">
                        <h5 class="card-title">Estatuto General de la UdeG</h5>
                        <p class="card-text"> </p>
                        <br>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/EG%20%28Abril%202024%29_rev.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2" style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 180px; width: 250px;">
                    <div class="card-body">
                        <h5 class="card-title">Reglamento General de Evaluación y Promoción de Alumnos</h5>
                        <p class="card-text"> </p>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/rgepa-oct-2017.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2" style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 180px; width: 250px;">
                    <div class="card-body">
                        <h5 class="card-title">Reglamento General de Titulación</h5>
                        <p class="card-text"> </p>
                        <br>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/RGT%20%28Abril%202023%29%2026.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
            
            

            <br>
            <div>
                <h4 class="mb-4 text-light"  style="background-color: rgba(82, 82, 255, 0.396)">Inmediata</h4>
            </div>


            <div class="d-flex justify-content-center">



                <div class="card m-2" style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 190px; width: 285px;">
                    <div class="card-body">
                        <h5 class="card-title">Reglamento de Protección contra la Exposición al Humo de Tabaco</h5>
                        <p class="card-text"> </p>
                        <a href="#" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                <div class="card m-2"   style="width: 18rem;" >
                    <img src="{{ asset('imgs/udglogo2.jpeg') }}" class="card-img-top" alt="..."  style="height: 190px; width: 285px;">
                    <div class="card-body">
                        <h5 class="card-title">Código de Ética (Feb 2018)</h5>
                        <p class="card-text"> </p>
                        <br>
                        <br>
                        <a href="https://secgral.udg.mx/sites/default/files/Normatividad_general/2018-03-02-codigo-de-etica-feb2018.pdf" class="btn btn-primary">Ver</a>
                    </div>
                </div>

                

            </div>

            <br>

            <div class="text-center">
            
                <a href="{{ route('/home') }}" class="btn btn-secondary">Volver al menu</a>
            </div>

</div>

        @endsection
    @else
        <script>
            window.location = "{{ url('/') }}";
        </script>
@endif
