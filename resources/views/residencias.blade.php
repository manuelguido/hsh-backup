@extends('layouts.app')

@section('title','Home Switch Home')

@section('content')

<div class="container container-classic">

    <div class="row">

        <div class="col-md-3 filter-card">

            <div class="card sticky-top overflow-hidden">
                <div class="card-header">
                    Busqueda
                </div>
                <form method="GET">
                    <ul class="filtros list-group list-group-flush">
                        <!--li class="list-group-item">
                            <p><i class="fa fa-map-marker-alt"></i> Ubicación</p>
                            <input type="text" class="form-control" placeholder="Ciudad"><br>
                            <input type="text" class="form-control" placeholder="Provincia"><br>
                        </li>
                        <li class="list-group-item">    
                            <p><i class="fas fa-book-open"></i> Tipo (Premium)</p>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input cursor-p" id="alquilerSwitch" checked>
                                <label class="custom-control-label cursor-p" for="alquilerSwitch">Alquiler</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input cursor-p" id="subastaSwitch" checked>
                                <label class="custom-control-label cursor-p" for="subastaSwitch">Subasta</label>
                            </div>
                        </li-->
                        <li class="list-group-item">
                            <p><i class="fas fa-calendar-alt"></i> Fecha</p>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Desde</label>
                                    <input id="date-from" type="date" class="form-control" name="date-from" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Hasta</label>
                                    <input id="date-to" type="date" class="form-control" name="date-to" autofocus>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item text-right">
                            <button type="submit" class="btn aqua-gradient btn-rounded my-0">Busqueda</button>                           
                        </li>
                    </ul>
                </form>
            </div>

        </div>

        <div class="col-md-9">

            @foreach ($subastas as $p)

                <div class="propiedad-card list-group-item card overflow-hidden uns">
                    <div class="row">
                        <a class="col-md-5" href="/subasta/{{ $p->idsubasta }}">
                            <div class="image-box overflow-hidden">
                                <img src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                            </div>
                        </a>
                        <a class="col-md-5 py-3" href="/property">
                            <h2>{{ $p->title }}</h2>
                            <p class="ubicacion-card color-blue"><i class="fa fa-map-marker-alt"></i> {{ $p->city }}, {{ $p->province }}</p>
                            <div>
                                Desde: {{ $p->begin_date }}
                                <br>
                                Hasta: {{ $p->end_date }}
                                <br>
                                <br> 
                            </div>
                            <!--span>
                                @include('includes.calification')
                            </span-->
                        </a>
                        <div class="col-md-2">
                            <!--i class="far fa-bookmark bookmark-icon cursor-p"></i-->
                            <!--a class="card-price" href="/property">$@php echo rand(100,400); echo 0; @endphp</a-->
                        </div>
                    </div>
                </div>

            @endforeach
            
        </div>

    </div>

</div>

@endsection