@extends('layouts.app')

@section('content')

<body onload="myFunction()">

<div class="container-fluid container-classic container-width-60">
        <!--Card-->
        <div class="card home-search">

            <!--Card content-->
            <div class="card-body">

            <!-- Form -->
            <form name="home-search">
                <!-- Heading -->
                <h1 class="dark-grey-text text-left">
                    <strong>Buscar tiempos compartidos</strong>
                </h1>
                <hr>

                <!--div class="form-group row">
                    <div class="col-md-6">
                        <label>Ciudad (Opcional)</label>
                        <input id="city" type="text" class="form-control" name="city" autofocus>
                    </div>
                    <div class="col-md-6">
                        <label>Provincia (Opcional)</label>
                        <input id="city" type="text" class="form-control" name="city" autofocus>
                    </div>
                </div-->

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Desde</label>
                        <input id="date-from" type="date" class="form-control" name="date-from" autofocus>
                    </div>
                    <div class="col-md-6">
                        <label>Hasta</label>
                        <input id="date-to" type="date" class="form-control" name="date-to" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Provincia</label>
                        <select required id="provincia" class="form-control" name="date-from" onchange="myFunction()" autofocus>
                            @foreach ($provincias as $p)
                                <option value="{{ $p->id }}" class="provincia_select"> {{ $p->nombre_provincia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Localidad</label>
                        @foreach ($provincias as $p)
                        <select class="form-control localidad_select" style="display: none" autofocus>
                            @foreach ($localidades as $l)
                                @if ($l->id_provincia == $p->id)
                                    <option value="{{ $l->id }}"> {{ $l->nombre_localidad }}</option>
                                @endif
                            @endforeach
                        </select>   
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="form-group row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn aqua-gradient btn-rounded my-0">Buscar</button>
                </div>
                </div>

            </form>
            <!-- Form -->

            </div>

        </div>
        <!--/.Card-->
    </div>
@endsection
