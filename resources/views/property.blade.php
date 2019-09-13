@extends('layouts.app')

@section('title','Propiedad')

@section('content')

<!-- Se declara esto solo para cargar el js de panel -->
<body onload="gallerySwitch(0)">

    <div class="container big-margin">
        @foreach ($property as $p)
            <div class="row">
                <div class="col-md-5 overflow-hidden">
                        <div class="row">
                            <div class="col-md-12 property-image fill">
                                
                                @if( !empty($p->img1))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img2))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img2) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img3))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img3) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img4))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img4) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img5))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img5) }}" alt="Imagen de propiedad">
                                @endif
                            </div>
                        </div>
                        <div class="row shadow3 property-subimages">
                                @php
                                    $i = 0;
                                @endphp
                                @if( !empty($p->img1))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch({{ $i++ }})">
                                        <img src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                                @if( !empty($p->img2))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch({{ $i++ }})">
                                        <img src="{{ Storage::url('property/'.$p->img2) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                                @if( !empty($p->img3))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch({{ $i++ }})">
                                        <img src="{{ Storage::url('property/'.$p->img3) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                                @if( !empty($p->img4))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch({{ $i++ }})">
                                        <img src="{{ Storage::url('property/'.$p->img4) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                                @if( !empty($p->img5))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch({{ $i++ }})">
                                        <img src="{{ Storage::url('property/'.$p->img5) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                        </div>
                    </div>
                    <div class="col-md-6 offset-1 property-info card py-4" style="padding: 30px;">
                        <h2>{{ $p->title }}<h2>
                        <hr>
                        <h5>Ubicación: <span class="color-blue" style><i class="fas fa-map-marker-alt"></i> {{  $localidad->first()->nombre_localidad  }}, {{ $provincia->first()->nombre_provincia }}, {{ $p->country }} </span></h5>
                        <h6>Descripción: {{ $p->description }}</h6>
                        <hr>
                        @if (count($sp) > 0)
                            <ul class="list-group">
                                <li class="list-group-item disabled"><i class="far fa-calendar-alt"></i> Semanas disponibles</li>
                                @foreach ($sp as $s)
                                    @php $si_es = false; @endphp
                                    @if (Auth::user()->premium)
                                        @php
                                            $si_es = true; 
                                        @endphp
                                    @elseif ($s->tipo <> 1)
                                        @php $si_es = true; @endphp
                                    @endif
                                    @if ($si_es)
                                        <li class="list-group-item"><a href="/semana_propiedad/{{ $s->id }}">Desde: {{ $s->fecha_inicio }}, hasta: {{ $s->fecha_cierre }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <h5>No se encuentran semanas disponibles por el momento</h5>
                        @endif
                    </div>
                </div>
        @endforeach 
    </div>
    <!--div class="container property-recomendations">
        <div class="row">
            <div class="col-md-12">
                <h3 class="py-3">También puede interesarte</h3>
            </div>
            {{--@for ($k = 0; $k < 4; $k++)

                @include('includes/home-card')
                
            @endfor--}}
        </div>
    </div>

@endsection