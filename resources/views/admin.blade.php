@extends('layouts.admin')

@section('content')

<!-- Se declara esto solo para cargar el js de panel -->

@php
    $code = 0;
@endphp

@if(Session::has('codigo'))
    @php
        $code = Session::get('codigo');
        Session()->forget('codigo');
    @endphp
@endif

<body onload="menuSwitch({{ $code }}); myFunction();">

<div class="container container-classic">
    <div class="row">
        <div class="col-md-12">
                @if(Session::has('success'))                
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('success') }}</strong>
                        <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(Session::has('error'))                
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('error') }}</strong>
                        <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            <div class="card panel-default">
                <div class="card-header" style="background: #fff !important;">Panel de administación</div>

                <div class="card-body" style="background: #f4f4f4;">
                    {{-- @component('components.who')
                    @endcomponent --}}
                    
                    <h1 id="profile-title"></h1>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item menuItem" onclick="menuSwitch(0)"><i class="fas fa-plus-circle"></i> Agregar propiedad</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(1)"><i class="fas fa-home"></i> Ver propiedades</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(2)"><i class="fas fa-play-circle"></i> Generar semana</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(3)"><i class="fas fa-plus-square"></i> Abrir subasta</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(4)"><i class="fas fa-stop-circle"></i> Listar subastas</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(5)"><i class="fas fa-plus-square"></i> Abrir hotsale</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(6)"><i class="fas fa-stop-circle"></i> Listar hotsales</li>


                                <li class="list-group-item menuItem" onclick="menuSwitch(7)"><i class="fas fa-award"></i> Solicitudes pendientes</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(8)"><i class="fas fa-list"></i> Listar reservas</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(9)"><i class="fas fa-users"></i> Listar usuarios</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(10)"><i class="fas fa-user-shield"></i> Listar administradores</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(11)"><i class="fas fa-user-plus"></i> Agregar administrador</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(12)"><i class="fas fa-tag"></i> Precios de suscripción</li>
                                <!--li class="list-group-item menuItem" onclick="menuSwitch(4)"><i class="fas fa-award"></i> Cobrar suscripciones mensuales</li-->

                                <!--li class="list-group-item menuItem" onclick="menuSwitch(4)"><i class="fas fa-file-invoice"></i> Listar reservas</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(7)"><i class="fas fa-file-invoice"></i> Dar de baja disponibilidad</li-->
                                <li class="list-group-item menuItem" onclick="menuSwitch(13)"><i class="fas fa-minus-circle"></i> Eliminar propiedades</li>
                                <li class="list-group-item menuItem" onclick="menuSwitch(14)"><i class="fas fa-database"></i> Eliminar BD</li>

                            </ul>
                            </div>
                        </div>
                    
                        <!-- Inicio de containers cambiables -->

                        <!-- Agregar residencias -->
                        <div class="container-fluid col-md-9 subItem">
                            <div class="text-center">                
                            <!-- Default form contact -->
                            <form method="post" action="/upload_property" enctype="multipart/form-data" class="col-md-12 text-left">
                                        {{ csrf_field() }}
                                        <h2 class="text-left mb-12">Nueva propiedad</h2><br>
                                    
                                        <!-- titulo -->
                                        <label>Nombre:</label>
                                        <input type="text" name="title" id="title" class="form-control mb-4" value="{{ old('title') }}" required autofocus>
                                    
                                        <!-- Descripción -->
                                        <label>Descripción</label>
                                        <div class="form-group">
                                            <textarea class="form-control rounded-0" name="description" id="description" rows="4" required>{{ old('description') }}</textarea>
                                        </div>

                                        <!-- Dirección -->
                                        <label>Dirección</label>
                                        <input type="text" name="address" id="address" class="form-control mb-4" value="{{ old('address') }}" required autofocus>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Provincia</label>
                                                <select class="form-control" id="provincia" name="provincia" onchange="myFunction()" autofocus required>
                                                    @foreach ($provincias as $p)
                                                        <option value="{{ $p->id }}" class="provincia_select"
                                                            @if (old('provincia') == $p->id)
                                                                selected
                                                            @endif
                                                        > {{ $p->nombre_provincia }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Localidad</label>
                                                @foreach ($provincias as $p)
                                                <select class="form-control localidad_select" id="city" name="city" style="display: none" autofocus>
                                                    @foreach ($localidades as $l)
                                                        @if ($l->id_provincia == $p->id)
                                                            <option value="{{ $l->id }}" 
                                                                @if (old('city') == $l->id)
                                                                    selected
                                                                @endif
                                                            > {{ $l->nombre_localidad }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>   
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <!-- País -->
                                        <label>País</label>
                                        <input type="text" name="country" id="country" class="form-control mb-4" value="Argentina" required>

                                        <!-- Precio
                                        <label>Precio</label>
                                        <input type="number" name="price" id="price" class="form-control mb-4" placeholder="Precio de alquiler" value="{{ old('price') }}" required-->


                                        <h4 class="text-left mb-2">Imágenes (Seleccione al menos la principal)</h4>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <label>Principal:</label>
                                                <input type="file" name="image1" id="image1" class="form-control btn-light mb-4" value="{{ old('image1') }}" style="margin: 0 !important; padding-bottom: 40px;" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <label>Imagen 2:</label>
                                                <input type="file" name="image2" id="image2" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <label>Imagen 3:</label>
                                                <input type="file" name="image3" id="image3" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <label>Imagen 4:</label>
                                                <input type="file" name="image4" id="image4" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <label>Imagen 5:</label>
                                                <input type="file" name="image5" id="image5" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                            </div>
                                        </div>
                                        
                                        <!-- Send button -->
                                        <div class="col-md-2 float-right" style="padding:0 !important;">
                                            <button class="btn btn-info btn-block" type="submit">Agregar</button>
                                        </div>
                                    </form>
                                    <!-- Default form contact -->
                            </div>
                        </div>
                        
                        <!-- Ver residencias -->
                        <div class="container-fluid col-md-9 subItem">
                                         
                                <!-- -->
                                @if($properties->isNotEmpty())

                                    @foreach ($properties as $p)
                                        @if ($p->available == 1)
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="/property/{{ $p->id }}">{{ $p->title }}</a>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ Storage::url('property/'.$p->img1) }}" style="height: 140px !important; max-width: 100% !important;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="color-black">Dirección: {{ $p->address }}</p>
                                                        <p class="color-black">Ciudad: {{ $p->nombre_localidad }}</p>
                                                        <p class="color-black">Provincia: {{ $p->nombre_provincia }}</p>
                                                        <p class="color-black">País: {{ $p->country }}</p>
                                                        <p class="color-black">Precio base: ${{ $p->price }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Descripción:</h6>
                                                        <p class="color-black"> {{ $p->description }}</p>
                                                        <hr>
                                                        @if (1 > 3)<a class="btn btn-success" href="/modify_property/{{ $p->id }}">Modificar datos</a>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        @endif
                                    @endforeach

                                @else
                                    @include('includes.banner', [
                                        'message' => "Aún no se han cargado propiedades en el sitio",
                                    ])
                                @endif
                            
                        </div>

                        <!-- Generar semana -->
                        <div class="container-fluid col-md-9 subItem">
                                @if($properties->isNotEmpty())
                                <!-- Default form contact -->
                                <form method="post" action="/generar_semana" enctype="multipart/form-data" class="col-md-12 text-left">
                                            {{ csrf_field() }}
                                            <h2 class="text-left mb-12">Generar semana</h2><br>
                                        
                                            <div class="row">
                                                <div class="col-md-6" style="padding:0 !important;">

                                                    <!-- titulo -->
                                                    <label>Propiedad</label>
                                                    <select name="property_id" id="property_id" class="browser-default custom-select mb-4" required>
                                                        <option value="" disabled selected>Elegir...</option>
                                                        @if (!empty($properties))
                                                            @foreach ($properties as $p)
                                                                <option value="{{ $p->id }}">{{ $p->title }}, {{ $p->address }}, {{ $p->nombre_localidad }}, {{ $p->nombre_provincia }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if (!empty($properties))
                                                        <input type="hidden" name="initial_value" id="initial_value" class="form-control mb-4" value="" required>
                                                    @endif
                                                </div>

                                                <div class="col-md-6" style="padding:0 !important;">
                                                    <!-- Fecha apertura -->
                                                    <label>Semana</label>
                                                    <select name="semana_id" id="semana_id" class="browser-default custom-select mb-4" required>
                                                        <option value="" disabled selected>Elegir semana...</option>
                                                        @if (!empty($semana))
                                                            @foreach ($semana as $s)
                                                                <option value="{{ $s->id }}">Desde: {{ $s->fecha_inicio }}, hasta: {{ $s->fecha_cierre }}</option>
                                                            @endforeach
                                                    @endif
                                                </select>                                                
                                            </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="padding:0 !important;">
                                                    <!-- titulo -->
                                                    <label>Precio</label>
                                                    <input type="number" name="precio_base" id="precio_base" class="form-control mb-4" required>
                                                </div>
                                            </div>                                <!-- Send button -->
                                <div class="col-md-2 float-right" style="padding:0 !important;">
                                    <button class="btn btn-info btn-block" type="submit">Abrir</button>
                                </div>
                            </form>
                            @else
                                @include('includes.banner', [
                                    'message' => "Aún no se han cargado propiedades en el sitio para generar nuevas semanas",
                                ])
                            @endif
                        </div>
                        
                        <!-- Abrir subasta -->
                        <div class="container-fluid col-md-9 subItem">
                                @if($posible_subasta)
                                    <!-- Default form contact -->
                                    <form method="post" action="/open_subasta" enctype="multipart/form-data" class="col-md-12 text-left">
                                        {{ csrf_field() }}
                                        <h2 class="text-left mb-12">Nueva subasta: </h2><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Semana de alquiler</label>
                                                <select name="id_sp" id="id_sp" class="browser-default custom-select mb-4" required>
                                                    <option value="" disabled selected>Elegir...</option>
                                                    @if (!empty($semana_propiedad))
                                                        @foreach ($semana_propiedad as $sp)
                                                            @if($sp->tipo == 2 && $sp->esta_activo == 0)
                                                                <option value="{{ $sp->id }}">{{ $sp->title }}, {{ $sp->address }}, {{ $sp->nombre_localidad }}, {{ $sp->nombre_provincia }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| Semana desde: {{ $sp->fecha_inicio }}, hasta: {{ $sp->fecha_cierre }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Precio inicial de subasta</label>
                                                <input type="number" name="nuevo_monto" id="nuevo_monto" class="form-control mb-4">                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 offset-md-9">
                                                <button class="btn btn-info btn-block float-right" type="submit">Abrir hotsale</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                @include('includes.banner', [
                                    'message' => "Por el momento no hay propiedades para abrir subastas",
                                ])
                            @endif
                        </div>

                        <!-- Listar Subastas -->
                        <div class="container-fluid col-md-9 subItem">
                                @if (count($subastas) > 0)
                                    @foreach ($subastas as $s)
                                        @if($s->esta_activo == 1)
                                        <form method="post" action="/cerrar_subasta" class="card" style="background: #fbfbfb !important;">
                                            {{ csrf_field() }}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ Storage::url('property/'.$s->img1) }}" style="height: 140px !important; max-width: 100% !important;">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h3>{{ $s->title }}</h3>
                                                        <p class="color-blue"><i class="fas fa-map-marker-alt"></i> {{ $s->nombre_provincia }}, {{ $s->nombre_localidad }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="id" id="id"  value="{{ $s->id }}" class="form-control mb-4" hidden>
                                                        <button class="btn btn-success btn-block float-right" type="submit">Cerrar subasta</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                        @endif
                                    @endforeach
                                @else
                                    @include('includes.banner', [
                                        'message' => "Aún no existen subastas activas",
                                    ])
                                @endif
                            </div>

                        <!-- Abrir hotsale -->
                        <div class="container-fluid col-md-9 subItem">
                                @if($posible_hotsale)
                                    <!-- Default form contact -->
                                    <form method="post" action="/open_hotsale" enctype="multipart/form-data" class="col-md-12 text-left">
                                        {{ csrf_field() }}
                                        <h2 class="text-left mb-12">Nuevo hotsale: </h2><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Semana de alquiler</label>
                                                <select name="id_sp" id="id_sp" class="browser-default custom-select mb-4" required>
                                                    <option value="" disabled selected>Elegir...</option>
                                                    @if (!empty($semana_propiedad))
                                                        @foreach ($semana_propiedad as $sp)
                                                            @if($sp->tipo == 3 && $sp->esta_activo == 0)
                                                                <option value="{{ $sp->id }}">{{ $sp->title }}, {{ $sp->address }}, {{ $sp->nombre_localidad }}, {{ $sp->nombre_provincia }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| Semana desde: {{ $sp->fecha_inicio }}, hasta: {{ $sp->fecha_cierre }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Precio del hotsale</label>
                                                <input type="number" name="nuevo_monto" id="nuevo_monto" class="form-control mb-4" required>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 offset-md-9">
                                                <button class="btn btn-info btn-block float-right" type="submit">Abrir hotsale</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    @include('includes.banner', [
                                        'message' => "Por el momento no hay propiedades para poner en hotsale",
                                    ])
                                @endif
                        </div>

                        <!-- Listar Hotsales  -->
                        <div class="container-fluid col-md-9 subItem">
                            @if (count($hotsales) > 0)
                                @foreach ($hotsales as $h)
                                    @if($h->esta_activo == 1)
                                    <form method="post" action="/close_hotsale" class="card">
                                        {{ csrf_field() }}
                                        <div class="card-body">
                                            {{ $h->title }}
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ Storage::url('property/'.$h->img1) }}" style="height: 140px !important; max-width: 100% !important;">
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="color-black">Dirección: {{ $h->address }}</p>
                                                    <p class="color-black">Ciudad: {{ $h->nombre_localidad }}</p>
                                                    <p class="color-black">Provincia: {{ $h->nombre_provincia }}</p>
                                                    <p class="color-black">País: {{ $h->country }}</p>
                                                    <p class="color-black">Precio base: {{ $h->nuevo_monto }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <hr>
                                                    <input type="text" name="id_hotsale" id="id_hotsale" value="{{ $h->id }}" class="form-control mb-4" hidden>
                                                    <button class="btn btn-warning btn-block float-right" type="submit">Cerrar hotsale</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    @endif
                                @endforeach
                            @else
                                @include('includes.banner', [
                                    'message' => "Aún no existen hotsales activos",
                                ])
                            @endif
                        </div>

                        <!-- Solicitudes Pendientes -->
                        <div class="container-fluid col-md-9 subItem">
                            @if (count($solicitudes) > 0)
                                @foreach ($solicitudes as $s)
                                    <div class="row">
                                        <form method="post" class="col-md-10 card py-3" action="/change_status" style="opacity: 0.85 !important;">
                                            {{ csrf_field() }}
                                            
                                            @php
                                                if ($s->premium) {
                                                    $tipo = 'básico';
                                                }
                                                else {
                                                    $tipo = 'premium';
                                                }
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Usuario</h4>
                                                    <p>Nombre: {{ $s->name }}</p>
                                                    <p>Email: {{ $s->email }}</p>
                                                    <p>Tipo de solicitud: {{ $tipo }}</p>
                                                    <p>Mensaje: {{ $s->descripcion }}</p>
                                                </div>
                                                <div class="col-md-6 text-right">
                                            
                                                    <input type="hidden" value="{{ $s->user_id }}" id="user_id" name="user_id" required>
                                                    <input type="hidden" value="{{ $s->id }}" id="solicitud_id" name="solicitud_id" required>
                                                    <input type="hidden" value="{{ $s->type }}" id="type" name="type" required>
                                                    <button type="submit" class="btn btn-success">Aceptar solicitud</button> 
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br>
                                @endforeach
                            @else
                                @include('includes.banner', [
                                    'message' => "Aún no hay solicitudes pendientes",
                                ])
                            @endif
                        </div>

                    <!-- Ver reservas -->
                    <div class="container-fluid col-md-8 subItem">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                    @if(count($userReservas) > 0)
                                    
                                    @foreach ($userReservas as $p)
                                        <a class="card" href="/semana_propiedad/{{ $p->id_sp}}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8 align-left">
                                                        <h3>{{ $p->name }}, {{ $p->email }}</h3>
                                                    </div>
                                                    <div class="col-md-4 align-left">
                                                        @if ($p->tipo == 1)
                                                            <button class="btn blue-gradient float-right" style="margin: 0 !important;" disabled>Alquiler</button>
                                                        @elseif ($p->tipo == 2)
                                                            <button class="btn purple-gradient float-right" style="margin: 0 !important;" disabled>Subasta</button>
                                                        @elseif ($p->tipo == 3)
                                                            <button class="btn peach-gradient float-right" style="margin: 0 !important;" disabled>Hotsale</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ Storage::url('property/'.$p->img1) }}" style="height: 140px !important; max-width: 100% !important;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="color-black">Dirección: {{ $p->address }}</p>
                                                        <p class="color-black">Ciudad: {{ $p->nombre_localidad }}</p>
                                                        <p class="color-black">Provincia: {{ $p->nombre_provincia }}</p>
                                                        <p class="color-black">País: {{ $p->country }}</p>
                                                        <p class="color-black">Precio base: ${{ $p->price }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Descripción:</h6>
                                                        <p class="color-black"> {{ $p->description }}</p>
                                                        <hr>
                                                        <h6>Semana:</h6>
                                                        <p class="color-blue">
                                                            Desde: {{ $p->fecha_inicio }}
                                                            <br>
                                                            Hasta: {{ $p->fecha_cierre }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <br>

                                    @endforeach
                                    

                                    @else
                                        @include('includes.banner', [
                                            'message' => "Aún no hay reservas de propiedades",
                                        ])
                                    @endif
                                </div>
                            </div>
                    </div>

                        <!-- Listar Usuarios -->
                        <div class="container-fluid col-md-9 subItem">
                                @if (count($userslist) > 0)
                                    @foreach ($userslist as $u)
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="row" style="padding: 10px 20px;">
                                                    <div class="col-md-8">
                                                        <h6><i class="fas fa-user-alt"></i> {{ $u->name }}</h6><hr>
                                                        <div id="demo-user-{{ $u->id }}" class="collapse">
                                                                <p>Email: {{ $u->email }}</p>
                                                                <p>Fecha de nacimiento: {{ $u->birth_date }}</p>
                                                                @php
                                                                if ($u->premium == 1) {
                                                                    $subscription_tipe = "PREMIUM";
                                                                }
                                                                else { 
                                                                    $subscription_tipe = "BÁSICO";
                                                                }
                                                                @endphp
                                                                <p>Tipo de suscripción: {{ $subscription_tipe }}</p>
                                                                <p>Cantidad de créditos: {{ $u->credits }}</p>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form method="post" action="/drop_user" class="card" style="background: #fbfbfb !important;">
                                                                            {{ csrf_field() }}
                                                                            <input type="text" name="id" id="id"  value="{{ $u->id }}" class="form-control mb-4" hidden>
                                                                            <input type="text" name="tipo" id="tipo"  value="users" class="form-control mb-4" hidden>
                                                                            <button class="btn btn-danger btn-block float-right" type="submit"><i class="fas fa-user-times"></i> Eliminar usuario</button>
                                                                        </form>
                                                                    </div>
                                                                </div>        
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button data-toggle="collapse" class="btn btn-indigo" data-target="#demo-user-{{ $u->id }}">Mostrar información</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <br>
                                    @endforeach
                                @else
                                    @include('includes.banner', [
                                        'message' => "Aún no hay usuarios registrados en el sitio",
                                    ])
                                @endif
                        </div>

                        <!-- Listar Admistradores -->
                        <div class="container-fluid col-md-9 subItem">    
                            @if (count($adminslist) > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                    @foreach ($adminslist as $a)
                                        <div class="card" style="padding: 10px 20px;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6><i class="fas fa-user-shield"></i> {{ $a->name }}
                                                            @php 
                                                                if (Auth::user()->email == $a->email) {
                                                                    echo "<b class='uns'>(USTED)</b>";
                                                                }
                                                            @endphp
                                                        </h6><hr>
                                                            <p>Email: {{ $a->email }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        @if (Auth::user()->email != $a->email)
                                                            <form method="post" action="/drop_user" class="card" style="background: #fbfbfb !important;">
                                                                {{ csrf_field() }}
                                                                <input type="text" name="id" id="id"  value="{{ $a->id }}" class="form-control mb-4" hidden>
                                                                <input type="text" name="tipo" id="tipo"  value="admins" class="form-control mb-4" hidden>
                                                                <button class="btn btn-danger btn-block float-right" type="submit"><i class="fas fa-user-times"></i> Eliminar administrador</button>
                                                            </form>  
                                                        @else
                                                            <button type="disabled" class="btn btn-light" disabled>Usted no puede eliminarse</button>
                                                        @endif
                                                    </div>

                                            </div>
                                        </div>
                                        <br>
                                    @endforeach
                                    </div>
                                </div>
                                @endif
                        </div>

                        <!-- Agregar administrador -->
                        <div class="container-fluid col-md-9 subItem">    
                            <div class="row">
                                <div class="col-md-6 offset-md-3">                                        
                                    <div class="card py-4">
                                        <form method="POST" role="form" class="col-md-12" action="/new_admin" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <h4><i class="fas fa-user-shield"></i> Nuevo administrador</h4>
                                            <hr>
                                            <!-- Nombre -->
                                            <label>Nombre:</label>
                                            <input type="text" name="name_admin" id="name_admin" class="form-control mb-4" value="{{ old('name_admin') }}" required>
                                            <!-- Nombre -->
                                            <label>Email:</label>
                                            <input id="email_admin" type="email" class="form-control mb-4" name="email_admin" value="{{ old('email_admin') }}" required>
                                            @if(Session::has('error_admin_email'))
                                                <span class="help-block">
                                                    <strong class="text-danger">Esta dirección de email ya existe en el sistema</strong>
                                                </span>
                                            @endif
                                            <!-- Nombre -->
                                            <label>Contraseña:</label>
                                            <input type="password" name="admin_password" id="admin_password" class="form-control mb-4" required autofocus>
                                            <br>
                                            <button class="btn btn-info btn-block float-right" type="submit"><i class="fas fa-user-plus"></i> Agregar administrador</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Precio de suscripción -->
                        <div class="container-fluid col-md-9 subItem">    
                            <div class="row">
                                <div class="col-md-6 offset-md-3">                                        
                                    <div class="card py-4">
                                    <form method="POST" role="form" class="col-md-12" action="/change_valores_suscripcion" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <h4><i class="fas fa-tag"></i> Valores de suscripción:</h4>
                                        <hr>
                                        <!-- Nombre -->
                                        <label>Básico:</label>
                                        <input type="number" name="valor_basico" id="valor_basico" class="form-control" value="{{ $valor_suscripcion->first()->valor_basico }}" required autofocus>
                                        @if(Session::has('valor_suscripcion_basica_cero'))
                                            <span class="help-block">
                                                <strong class="text-danger">El valor de suscripción debe ser mayor que cero</strong>
                                            </span>
                                        @endif
                                        <br>
                                        <!-- Nombre -->
                                        <label>Premium:</label>
                                        <input type="number" class="form-control" id="valor_premium" name="valor_premium" value="{{ $valor_suscripcion->first()->valor_premium }}" required autofocus>
                                        @if(Session::has('valor_suscripcion_basica_cero'))
                                            <span class="help-block">
                                                <strong class="text-danger">El valor de suscripción debe ser mayor que cero</strong>
                                            </span>
                                        @endif
                                        @if(Session::has('valor_premium_menor'))
                                            <span class="help-block">
                                                <strong class="text-danger">El valor de suscripción premium debe ser mayor que el de suscripción básica</strong>
                                            </span>
                                        @endif
                                        <br>
                                        <br>
                                        <button class="btn btn-info btn-block float-right" type="submit">Actualizar valores</button>
                                    </form>
                                </div></div>
                            </div>
                        </div>
                        
                        <!-- Eliminar permanentemente -->
                        <div class="container-fluid col-md-9 subItem">
                                @if (!empty($properties))
                                    @foreach ($properties as $p) 
                                        <form method="post" action="/delete_propiedad" class="card" href="home" style="background: #fbfbfb !important;">
                                            {{ csrf_field() }}
                                            <div class="card-body">
                                                {{ $p->title }}
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ Storage::url('property/'.$p->img1) }}" style="height: 140px !important; max-width: 100% !important;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="color-black">Dirección: {{ $p->address }}</p>
                                                        <p class="color-black">Ciudad: {{ $p->nombre_localidad }}</p>
                                                        <p class="color-black">Provincia: {{ $p->nombre_provincia }}</p>
                                                        <p class="color-black">País: {{ $p->country }}</p>
                                                        <p class="color-black">Precio base: {{ $p->price }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6>Descripción:</h6>
                                                        <p class="color-black"> {{ $p->description }}</p>
                                                        <input type="text" name="id" id="id"  value="{{ $p->id }}" class="form-control mb-4" hidden>
                                                        <button class="btn btn-danger btn-block float-right" type="submit">Eliminar permanentemente</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </form>
                                        <br>
                                    @endforeach
                                @else
                                    @include('includes.banner', [
                                        'message' => "Aún no se han cargado propiedades en el sitio",
                                    ])
                                @endif
                            
                        </div>

                        <!-- Eliminar BD -->
                        <div class="container-fluid col-md-9 subItem">
                            <div class="row">
                                <div class="col-md-3 offset-md-4">
                                    <form method="post" action="/delete_db" class="card" style="background: #fbfbfb !important;">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger btn-block float-right" type="submit">Eliminar BD</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
