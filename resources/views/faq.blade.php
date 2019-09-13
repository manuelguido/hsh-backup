@extends('layouts.app')

@section('title','Home Switch Home')

@section('content')

<div class="container card simple-div">
    <div class="row">
        <div class="col-md-12">
            <h1><i class="far fa-question-circle"></i>&nbsp;Preguntas frecuentes</h1>
            <hr>
                <div class="form-group">
                <h3>Qué es Home Switch Home</h3>
                    <p>Es un sitio para el alquiler de tiempos compartidos</p>
                </div>
                <div class="form-group">
                <h3>Cómo funciona?</h3>
                    <p>Un usuario desea alquilar un tiempo compartido durante un perído de tiempo, mediante una subasta.</p>
                </div>
                <div class="form-group">
                <h3>Cuanto dura el alquiler?</h3>
                    <p>Un alquiler dura 7 dias.</p>
                </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 text-center">
        <br>
        <h2>No encuentras lo que buscas?</h2><br>
        <a href="/contact-us" class="btn btn-info">Contáctanos</a>
    </div>
</div>

@endsection