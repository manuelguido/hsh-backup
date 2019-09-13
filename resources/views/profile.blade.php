@extends('layouts.app')

@section('title','Contácto')

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
        <div class="card-header" style="background: #fff !important;">Perfil de usuario</div>
            <div class="card-body" style="background: #f4f4f4;">

                <h1 id="profile-title"></h1>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item menuItem" onclick="menuSwitch(0)"><i class="far fa-address-card"></i> Información Personal</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(1)"><i class="fa fa-star"></i> Mis Créditos</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(2)"><i class="fas fa-award"></i> Suscripción de usuario</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(3)"><i class="far fa-credit-card"></i> Medios de pago</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(4)"><i class='fas fa-bookmark'></i> Ver favoritos</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(5)"><i class="fas fa-list"></i> Ver mis reservas</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(6)"><i class="fas fa-list"></i> Ver mis subastas</li>
                            <li class="list-group-item menuItem" onclick="menuSwitch(7)"><i class="fas fa-lock"></i> Cambiar Contraseña</li>
                            <li class="list-group-item menuItem" onclick="showLogout()">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off"></i> Cerrar Sesión
                            </a>
                            </li>
                        </ul>
                        </div>
                    </div>
                
                    <!-- Inicio de containers cambiables -->

                    <!-- Informacion Personal -->
                    <div class="container-fluid col-md-8 subItem">
                        <div class="row">                
                            <div class="col-md-8">
                                <form method="post" action="/update_profile" enctype="multipart/form-data" class="col-md-12">
                                {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Nombre y apellido:</label>
                                        <input type="hidden" id="id" name="id" value="{{ $user->first()->id  }}" required>
                                        <input type="text" id="name" name="name" class="form-control personal-input" disabled="true" value="{{ $user->first()->name }}" required>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">El nombre no puede contener números o caracteres especiales</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" id="email" name="email" class="form-control personal-input" disabled="true" value="{{ $user->first()->email  }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong class="text-danger">Esta dirección de email ya existe en el sistema</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha de nacimiento:</label>
                                        <input type="date" id="birth_date" name="birth_date" class="form-control personal-input" disabled="false" value="{{ $user->first()->birth_date  }}" required>
                                        @if ($errors->has('birth_date'))
                                            <span class="help-block">
                                                <strong class="text-danger">Debes tener al menos 18 años para registrarte en el sitio</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <br>
                                    <div class="form-group text-center">
                                        <span type="button" class="btn btn-info" id="editInfo" onclick="saveInfo()">Editar Información <i class="far fa-edit"></i></span>
                                        <button type="submit" class="btn btn-info" id="saveInfo" style="display: none;">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Comprar Créditos -->
                    <div class="container-fluid col-md-8 subItem">
                        <h2>Créditos disponibles: {{ $user->first()->credits }}</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Suscripción Premium -->
                    <div class="container-fluid col-md-8 subItem">
                        @php
                            if ($user->first()->premium) {
                                $status = 'premium';
                                $status2 = 'básico';
                                $solicitud_value = '0';
                            }
                            else {
                                $status = 'básico';
                                $status2 = 'premium';
                                $solicitud_value = '1';
                            }
                        @endphp
                        
                        <h2>Estado: usuario {{ $status }}</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                @if (count($user_solicitudes) == 0) 
                                <form method="post" action="/premium_updown" enctype="multipart/form-data" class="col-md-12">
                                    {{ csrf_field() }}
                                    <!-- Descripción -->
                                    <div class="form-group">
                                        @if (!($user->first()->premium))
                                            <h4>¿Por qué quieres cambiar tu suscripción?</h4>
                                        @else
                                            <h4>¿Por qué quieres dar de baja tu suscripción premium?</h4>
                                        @endif
                                        <textarea class="form-control rounded-0" name="descripcion" id="descripcion" rows="4" placeholder=""></textarea>
                                    </div>
                                    <input type="hidden" value="{{ $user->first()->id }}" id="user_id" name="user_id" required>
                                    <input type="hidden" value="{{ $solicitud_value }}" id="value" name="value" required>
                                    <button type="submit" class="btn btn-info">Enviar solicitud</button> 
                                </form>
                                @else
                                    <div class="container">
                                        <div class="row text-center card">
                                            <div class="col-md-12 text-center card-header">
                                                <h4>Ya has enviado una solicitud para pasar a usuario {{ $status2 }}.</h4>
                                            </div>
                                            <div class="col-md-12 text-center card-body">
                                                    <i class="fas fa-envelope-open-text" style="font-size: 40px !important;"></i>
                                                <p>Ahora debes comunicarse por teléfono o acercarse a la oficina física de la empresa.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Medios de Pago -->
                    <div class="container-fluid col-md-8 subItem">
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h4>Tu medio de pago actual: </h4>
                                            <h6>Nombre: {{ $user->first()->card_name }}</h6>
                                            <h6>Tarjeta: **** **** **** @php echo substr($user->first()->card_number, 12);   @endphp</h6>
                                            <h6>CVV: ***</h6>
                                            <h6>Fecha de vencimiento: {{ $user->first()->card_expdate }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <form method="post" action="/change_creditcard" enctype="multipart/form-data" class="col-md-12">
                                    {{ csrf_field() }}
                                    <h2>Actualizar medio de pago:</h2>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" value="{{ $user->first()->id }}" id="user_id" name="user_id" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group{{ $errors->has('card_name') ? ' has-error' : '' }}">
                                                    <label>Nombre de la tarjeta</label>
                                                    <input type="text" class="form-control" id="card_name" name="card_name" value="{{ old('card_name') }}" required>
                                                    @if ($errors->has('card_name'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">El nombre en la tarjeta no puede contener números o caracteres especiales</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group{{ $errors->has('card_number') ? ' has-error' : '' }}">
                                                    <label>Número de tarjeta</label>
                                                    <input type="number" class="form-control" id="card_number" name="card_number" placeholder="Máximo 16 dígitos" value="{{ old('card_number') }}" required>
                                                    @if ($errors->has('card_number'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">El numero de la tarjeta debe ser de 16 dígitos</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group{{ $errors->has('card_cvv') ? ' has-error' : '' }}">
                                                    <label>CVV</label>
                                                    <input type="number" class="form-control" id="card_cvv" name="card_cvv" placeholder="Máximo 3 dígitos" value="{{ old('card_cvv') }}" required>
                                                    @if ($errors->has('card_cvv'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">El código CVV de la tarjeta debe ser de 3 dígitos</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group{{ $errors->has('card_expdate') ? ' has-error' : '' }}">
                                                    <label>Vencimiento</label>
                                                    <input type="date" class="form-control" id="card_expdate" name="card_expdate" value="{{ old('card_expdate') }}" required>
                                                    @if ($errors->has('card_expdate'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">La tarjeta de crédito no puede estar vencida</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-group text-center">
                                        <button class="btn btn-outline-default waves-effect" id="editInfo" onclick="saveInfo()">Actualizar tarjeta <i class="fas fa-key"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Ver favoritos -->
                    <div class="container-fluid col-md-8 subItem">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                    @if(count($userFavoritos) > 0)
                                    
                                    @foreach ($userFavoritos as $p)
                                        <a class="card" href="/semana_propiedad/{{ $p->id_sp}}">
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
                                                        <h6>Semana</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <br>

                                    @endforeach
                                    

                                    @else
                                        @include('includes.banner', [
                                            'message' => "Aún no has agregado favoritos",
                                        ])
                                    @endif
                                </div>
                            </div>
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
                                                    <div class="col-md-12 align-left">
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
                                            'message' => "Aún no tienes reservas",
                                        ])
                                    @endif
                                </div>
                            </div>
                    </div>

                    <!-- Ver subastas -->
                    <div class="container-fluid col-md-8 subItem">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                    @if(count($userSubastas) > 0)
                                    
                                    @foreach ($userSubastas as $p)
                                        <a class="card" href="/semana_propiedad/{{ $p->id_sp}}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 align-left">
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
                                            'message' => "Aún no estas participando de ninguna subasta",
                                        ])
                                    @endif
                                </div>
                            </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="container-fluid col-md-8 subItem">
                        <div class="row justify-content-md-center">
                            <div class="col-md-10">
                                <form method="post" action="/change_password" enctype="multipart/form-data" class="col-md-12">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Contraseña actual</label>
                                        <input type="hidden" class="form-control" value="{{ $user->first()->id }}" id="user_id" name="user_id" required>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nueva Contraseña:</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Repetir nueva contraseña:</label>
                                        <input type="password" class="form-control" id="repeat_new" name="repeat_new" required>
                                    </div>
                                    <br>
                                    <div class="form-group text-center">
                                        <button class="btn btn-outline-default waves-effect" id="editInfo" onclick="saveInfo()">Cambiar contraseña <i class="fas fa-key"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection