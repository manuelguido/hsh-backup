@extends('layouts.app')

@section('title','Home Switch Home')

@section('content')

<div class="container container-classic">

    <div class="row">

        <div class="col-md-3 filter-card">

            <div class="card sticky-top overflow-hidden">
                <div class="card-header">
                    Filtrar
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
                            <button type="submit" class="btn aqua-gradient btn-rounded my-0">Buscar</button>                           
                        </li>
                    </ul>
                </form>
            </div>

        </div>

        <div class="col-md-9">

            @for ($i = 1; $i <= 10; $i++)

                <div class="propiedad-card list-group-item card overflow-hidden uns">
                    <div class="row">
                        <a class="col-md-5" href="/property">
                            <div class="image-box overflow-hidden">
                                <img src="{{ asset('img/img-pruebas/casa'.rand(1,5).'.jpg') }}" alt="Imagen de propiedad">
                            </div>
                        </a>
                        <a class="col-md-5 py-3" href="/property">
                            <h2>Nombre de propiedad {{ $i }}</h2>
                            <p class="ubicacion-card color-blue"><i class="fa fa-map-marker-alt"></i> Mar del Plata, Argentina</p>
                            <div>
                                Desde: 00-00-00
                                <br>
                                Hasta: 00-00-00
                                <br>
                                <br> 
                            </div>
                            <!--span>
                                @include('includes.calification')
                            </span-->
                        </a>
                        <div class="col-md-2">
                            <!--i class="far fa-bookmark bookmark-icon cursor-p"></i-->
                            <a class="card-price" href="/property">$@php echo rand(100,400); echo 0; @endphp</a>
                        </div>
                    </div>
                </div>

            @endfor
            
        </div>

    </div>

</div>

@endsection