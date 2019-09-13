@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center simple-div">
        <div class="col-md-6">
            @if ($errors->has('email'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Los datos ingresados no son correctos</strong>
                    <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->first('password'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Password</strong>
                    <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card s-default">
                <div class="card-header">Iniciar sesión</div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">E-Mail</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label">Contraseña</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar Sesión
                                </button>

                                <!--a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvidaste tu contraseña?
                                </a-->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Aún no tienes cuenta? <a href="register">Regístrate</a></p>
                        <p>Olvidaste tu contraseña? <a href="show_reset_password">Recuperala aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
