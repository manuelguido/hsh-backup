@extends('layouts.app')

@section('title','Home Switch Home')

@section('content')

<div class="container container-classic">

    <div class="row">

        @if($properties->isNotEmpty())

        <div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-6" style="vertical-align: bottom;">
                        <h2 class="" style="line-height: 70px;">Disponibilidad de alquiler</h2>    
                    </div>
                    <div class="col-md-6" style="vertical-align: bottom;">
                        <a href="properties" class="btn float-right" style="background: rgb(102,205,170); color:white; vertical-align: bottom;">Ver todas las residencias</a>
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
                        <a class="col-md-5 py-3" href="/property/{{ $p->id}}">
                            <h2>{{ $p->title }}</h2>
                            <p class="ubicacion-card color-blue"><i class="fa fa-map-marker-alt"></i> {{ $p->nombre_localidad }}, {{ $p->nombre_provincia }}, {{ $p->country }}</p>
                            
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
                'message' => "No se encuentran alquileres disponibles",
            ])

        @endif

    </div>

</div>

@endsection