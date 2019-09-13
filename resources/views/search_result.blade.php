@extends('layouts.app')

@section('title','Home Switch Home')

@section('content')

<div class="container container-classic">

    <div class="row">

        @if($properties->isNotEmpty())

        <div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-12" style="vertical-align: bottom;">
                        <h2 class="" style="line-height: 70px;">Resultado de búsqueda</h2>    
                    </div>
                </div>
                <hr>
            </div>

        <div class="col-md-8 offset-md-2">

                @foreach ($properties as $p)

                <div class="propiedad-card list-group-item card overflow-hidden uns">
                    <div class="row">
                        <a class="col-md-5" href="/property/{{ $p->id}}">
                            <div class="image-box overflow-hidden">
                                <img src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                            </div>
                        </a>
                        <a class="col-md-5 py-3" href="/semana_propiedad/{{ $p->id_sp}}">
                            <h2>{{ $p->title }}</h2>
                            <p class="ubicacion-card color-blue"><i class="fa fa-map-marker-alt"></i> {{ $p->nombre_localidad }}, {{ $p->nombre_provincia }}, {{ $p->country }}</p>
                            <br>
                            <p class="ubicacion-card">Desde: {{ $p->fecha_inicio }}<br>Hasta: {{ $p->fecha_cierre }}</p>
                            
                            <!--span>
                                @include('includes.calification')
                            </span-->
                        </a>
                        <div class="col-md-2">
                            <!--i class="far fa-bookmark bookmark-icon cursor-p"></i-->
                        </div>
                    </div>
                </div>

            @endforeach
            
        </div>

        @else

            @include('includes.banner', [
                'message' => "No se han encontrado alquileres disponibles para esas fechas",
            ])

        @endif

    </div>

</div>

@endsection