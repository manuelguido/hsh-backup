@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center simple-div">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Registro de usuario</div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12 control-label">Nombre y apellido</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">El nombre no puede contener números o caracteres especiales</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">E-Mail</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">Esta dirección de email ya existe en el sistema</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                            <label for="birth_date" class="col-md-12 control-label">Fecha de nacimiento</label>

                            <div class="col-md-12">
                                <input id="birth_date" type="date" class="form-control" name="birth_date" value="{{ old('birth_date') }}" required>

                                @if ($errors->has('birth_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">Debes tener al menos 18 años para registrarte en el sitio</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label">Contraseña</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">Las contraseñas no coinciden</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-12 control-label">Repetir contraseña</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('card_name') ? ' has-error' : '' }}">
                            <label for="card_name" class="col-md-12 control-label">Nombre en la tarjeta</label>

                            <div class="col-md-12">
                                <input id="card_name" type="text" class="form-control" name="card_name" value="{{ old('card_name') }}" required>

                                @if ($errors->has('card_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">El nombre en la tarjeta no puede contener números o caracteres especiales</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('card_number') ? ' has-error' : '' }}">
                            <label for="card_number" class="col-md-12 control-label">Numero de la tarjeta</label>

                            <div class="col-md-12">
                                <input id="card_number" type="number" class="form-control" name="card_number" placeholder="máximo 16 caracteres" value="{{ old('card_number') }}" required>

                                @if ($errors->has('card_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">El numero de la tarjeta debe ser de 16 dígitos</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('card_cvv') ? ' has-error' : '' }}">
                            <label for="card_cvv" class="col-md-12 control-label">CVV</label>

                            <div class="col-md-12">
                                <input id="card_cvv" type="number" class="form-control" name="card_cvv" value="{{ old('card_cvv') }}" required>

                                @if ($errors->has('card_cvv'))
                                    <span class="help-block">
                                        <strong class="text-danger">El código CVV de la tarjeta debe ser de 3 dígitos</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('card_expdate') ? ' has-error' : '' }}">
                            <label for="card_expdate" class="col-md-12 control-label">Fecha de vencimiento de tarjeta</label>

                            <div class="col-md-12">
                                <input id="card_expdate" type="date" class="form-control" name="card_expdate" value="{{ old('card_expdate') }}" required>

                                @if ($errors->has('card_expdate'))
                                    <span class="help-block">
                                        <strong class="text-danger">La tarjeta de crédito no puede estar vencida</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Ya tienes cuenta? <a href="login">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
