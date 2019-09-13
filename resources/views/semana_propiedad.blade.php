@extends('layouts.app')

@section('title','Propiedad')

@section('content')

<!-- Se declara esto solo para cargar el js de panel -->
<body onload="gallerySwitch(0)">

    <div class="container big-margin">
        @foreach ($sp as $p)
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
                        <div class="row">
                                @if(Session::has('success2'))                
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('success2') }}</strong>
                                    <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(Session::has('error2'))                
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('error2') }}</strong>
                                    <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="col-md-8">
                                <h2>{{ $p->title }}</h2>
                            </div>
                            <div class="col-md-4 align-right">
                                @if ($p->tipo == 1)
                                    <button class="btn blue-gradient float-right" style="margin: 0 !important;" disabled>Alquiler</button>
                                @elseif ($p->tipo == 2)
                                    <button class="btn purple-gradient float-right" style="margin: 0 !important;" disabled>Subasta</button>
                                @elseif ($p->tipo == 3)
                                    <button class="btn peach-gradient float-right" style="margin: 0 !important;" disabled>Hotsale</button>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            @php
                                $b = 0;
                            @endphp
                            @foreach ($userFavoritos as $f)
                                @if ($f->id_sp == $p->SemId)
                                    @php $b = 1; @endphp
                                @endif
                            @endforeach

                            @php
                                if ($b) {
                                    $icon = "<i class='fas fa-bookmark' style='font-size: 30px; color: orange;'></i>";
                                    $add_value = 0;
                                    $texto = "Quitar de favoritos: ";
                                }
                                else {
                                    $icon = "<i class='far fa-bookmark' style='font-size: 30px; color: orange;'></i>";
                                    $add_value = 1;
                                    $texto = "Añadir de favoritos: ";
                                }
                            @endphp
                            <div class="col-md-12">
                                    @if(Session::has('success'))                
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('success') }}</strong>
                                        <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <form method="post" action="/add_favorito" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="id_sp" id="id_sp" value="{{ $p->SemId }}">
                                    <input type="hidden" name="add_value" id="add_value" value="{{ $add_value }}">
                                    <h2>{{ $texto }}
                                        <button type="submit" style="outline: none !important; border:none; background: none;">
                                            @php
                                                echo $icon;
                                            @endphp
                                        </button>
                                    </h2>
                                    <br>
                                </form>
                            </div>
                        </div>
                        <br>
                        <h5>Ubicación: <span class="color-blue" style><i class="fas fa-map-marker-alt"></i> {{ $p->nombre_localidad }}, {{ $p->nombre_provincia }}, {{ $p->country }} </span></h5>
                        <h6>Descripción: {{ $p->description }}</h6>
                        <hr>
                        <h2>Semana</h2>
                        <h4 class="text-blue">Desde: {{ $p->fecha_inicio }} <i class="far fa-calendar-alt"></i><h4>
                        <h4 class="text-blue">Hasta: {{ $p->fecha_cierre }} <i class="far fa-calendar-alt"></i><h4>    
                        <hr>
                        @if ($p->disponible == 1 && $p->tipo == 1) 
                            @if (Auth::user()->premium == 1)
                            Precio de Alquiler: ${{ $p->precio_base }}
                            <br>
                            <br>
                            <form method="post" action="/alquilar_propiedad" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="id_sp" id="id_sp" value="{{ $p->SemId }}">
                                <input type="number" name="nuevo_monto" id="nuevo_monto" class="form-control mb-4">                                                
                                <button class="btn btn-info btn-block" type="submit">Realizar reserva</button>
                                <br>
                            </form>
                            @endif
                        @elseif ($p->disponible == 1 && $p->tipo == 2)
                            @if ($p->esta_activo == 1)
                                @php $partic = false; @endphp
                                @foreach ($participa_subasta as $ps)
                                    @if ($ps->id_subasta == $subasta->first()->id)
                                        @php $partic = true; @endphp
                                    @endif
                                @endforeach
                                @if ($partic)
                                <h3>Puja para ganar la subasta:</h3>
                                <br>
                                        @php                                                
                                            if ($hay_puja)
                                                $valor_actual_subasta = $max_puja;
                                            else {
                                                $valor_actual_subasta = $p->precio_base;
                                            }
                                        @endphp
                                        <form method="post" action="/pujar_subasta" enctype="multipart/form-data" class="row">
                                        {{ csrf_field() }}
                                            <div class="col-md-6">
                                                <label>Monto actual:</label>
                                                <input type="text" name="valor_actual" id="valor_actual" value="{{ $valor_actual_subasta }}"class="form-control mb-4 uns" readonly required>
                                         
                                            @if (!$es_mayor_postor)
                                                    <label>Ingresar puja:</label>
                                                    <input type="number" name="nuevo_monto" id="nuevo_monto" class="form-control mb-4" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <br><br><br><br><br>
                                                    <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="id_subasta" id="id_subasta" value="{{ $subasta->first()->id }}">
                                                    
                                                    <button class="btn btn-success btn-block" type="submit">Pujar</button>
                                                <br>
                                            @else
                                                <h4>No puedes pujar por el momento, dado que eres el mayor postor de la subasta hasta ahora</h4>
                                            @endif
                                            </div>
                                        </form>
                                @else
                                    <!-- Formulario de participar -->
                                    Monto actual de subasta: ${{ $p->precio_base }} <!-----asdasdasdasdasdas--->
                                        <br>
                                        <br>
                                        <form method="post" action="/participar_subasta" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="id_sp" id="id_sp" value="{{ $p->SemId }}">
                                            <input type="hidden" name="id_subasta" id="id_subasta" value="{{ $subasta->first()->id }}">
                                            <button class="btn btn-info btn-block" type="submit">Participar en subasta</button>
                                            <br>
                                        </form>
                                    @endif
                            @else
                                <br>
                                La subasta aún no está abierta.<br>
                                Por el momento puedes agregarla a tus favoritos y te avisaremos por correo cuando abra.
                            @endif
                        @elseif ($p->disponible == 1 && $p->tipo == 3)
                            @if ($p->esta_activo == 1)
                                @foreach ($hotsale as $h)
                                    Precio de Alquiler: ${{ $h->nuevo_monto }}    
                                @endforeach
                                <br>
                                <br>
                                <form method="post" action="/alquilar_propiedad" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="id_sp" id="id_sp" value="{{ $p->SemId }}">
                                    <input type="hidden" name="nuevo_monto" id="nuevo_monto" value="{{ $p->precio_base }}">
                                    <button class="btn btn-warning btn-block" type="submit">Alquilar por hotsale</button>
                                    <br>
                                </form>
                            @else
                                <br>
                                El hotsale aún no está abierto.<br>
                                Por el momento puedes agregarlo a tus favoritos y te avisaremos por correo cuando abra.
                            @endif
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