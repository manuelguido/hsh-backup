@extends('layouts.app')

@section('title','Contácto')

@section('content')


<div class="container card simple-div">

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif

    <h1><i class="fa fa-envelope"></i>&nbsp;Contácto</h1>
    <hr>

    {!! Form::open(['route'=>'contactus.store']) !!}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    {!! Form::label('Nombre:') !!}
    {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Ingrese su nombre']) !!}
    <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    {!! Form::label('Email:') !!}
    {!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Ingrese su email']) !!}
    <span class="text-danger">{{ $errors->first('email') }}</span>
    </div>
    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
    {!! Form::label('Mensaje:') !!}
    {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Escriba su mensaje']) !!}
    <span class="text-danger">{{ $errors->first('message') }}</span>
    </div>
    <br>
    <div class="form-group">
    <button class="btn btn-info float-right">Enviar</button>
    </div>
    {!! Form::close() !!}
    </div>

</div>

@endsection