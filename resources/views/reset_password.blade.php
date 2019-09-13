@extends('layouts.app')

@section('title','Recuperar contraseña')

@section('content')


<div class="container simple-div justify-content-center card">
    <div class="row">

        <div class="col-md-6 offset-md-3">
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


            <form action="/reset_password" method="post" enctype="multipart/form-data" class="col-md-12 text-left">
                {{ csrf_field() }}
                <h3>Solicita una nueva contraseña:</h3>
                <input type="email" name="email" id="email" class="form-control mb-4" placeholder="email" required>
                <div class="row" style="padding: 0px !important;">
                    <div class="col-md-5 offset-md-5" style="margin: 0px !important;">
                        <button class="btn btn-info btn-block" type="submit">Solicitar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection