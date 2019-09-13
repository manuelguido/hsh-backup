@extends('layouts.app')

@section('title','Propiedad')

@section('content')

<!-- Se declara esto solo para cargar el js de panel -->
<body onload="gallerySwitch(0)">

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
                    </div>
            </div>
        <div class="row card" style="padding: 30px 20px;">
            <div class="col-md-12">
                    <div class="text-center">         

                        @foreach ($property as $p)                            
                            <!-- Default form contact -->
                            <form method="post" action="/modify_property_send" enctype="multipart/form-data" class="col-md-12">
                                        {{ csrf_field() }}
                                        <h2 class="text-left mb-12">Modificar residencia: {{ $p->title }}</h2><br>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <!-- titulo -->
                                                <label>Titulo</label>
                                                <input type="text" name="title" id="title" class="form-control mb-4" placeholder="Título" value="{{ $p->title }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>
                                                <input type="hidden" name="id" id="id" class="form-control mb-4" value="{{ $p->id }}" required>

                                                <!-- Descripción -->
                                                <label>Descripción</label>
                                                <div class="form-group">
                                                    <textarea class="form-control rounded-0" name="description" id="description" rows="4" placeholder="Descripción">{{ $p->description }}</textarea>
                                                </div>

                                                <!-- Dirección -->
                                                <label>Dirección</label>
                                                <input type="text" name="address" id="address" class="form-control mb-4" placeholder="Dirección" value="{{ $p->address }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>

                                                <!-- Ciudad -->
                                                <label></label>
                                                <input type="hidden" name="city" id="city" class="form-control mb-4" placeholder="Ciudad" value="{{ $p->city }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>

                                                <!-- Provincia -->
                                                <label></label>
                                                <input type="hidden" name="province" id="province" class="form-control mb-4" placeholder="Provincia" value="{{ $p->province }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>

                                                <!-- País -->
                                                <label>País</label>
                                                <input type="text" name="country" id="country" class="form-control mb-4" placeholder="País" value="{{ $p->country }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>

                                                <!-- Precio -->
                                                <label>Precio base</label>
                                                <input type="number" name="price" id="price" class="form-control mb-4" placeholder="Precio de alquiler" value="{{ $p->price }}" @if (!$reservas->isEmpty()) { echo readonly } @endif>

                                            </div>
                                            <div class="col-md-6">
                                                    <div class="row" style="height: 80px; background: #d9d9d9;">
                                                        <div class="col-md-2">
                                                            @if( !empty($p->img1))
                                                                <img src="{{ Storage::url('property/'.$p->img1) }}" style="height: 80px !important; max-width: 100% !important;">
                                                            @else
                                                                <i class="far fa-image" style="margin-top: 20px; font-size: 40px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <label>Imagen 1:</label>
                                                            <input type="file" name="image1" id="image1" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row" style="height: 80px; background: #d9d9d9;">
                                                        <div class="col-md-2">
                                                            @if( !empty($p->img2))
                                                                <img src="{{ Storage::url('property/'.$p->img2) }}" style="height: 80px !important; max-width: 100% !important;">
                                                            @else
                                                                <i class="far fa-image" style="margin-top: 20px; font-size: 40px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <label>Imagen 2:</label>
                                                            <input type="file" name="image2" id="image2" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                                        </div>
                                                        <div class="col-md-4" style="padding-top: 30px;">
                                                            <input type="checkbox" value="1" name="eliminar2" id="eliminar2">
                                                            <label class="form-check-label" for="eliminar2">
                                                                Eliminar
                                                            </label>    
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row" style="height: 80px; background: #d9d9d9;">
                                                        <div class="col-md-2">
                                                            @if( !empty($p->img3))
                                                                <img src="{{ Storage::url('property/'.$p->img3) }}" style="height: 80px !important; max-width: 100% !important;">
                                                            @else
                                                                <i class="far fa-image" style="margin-top: 20px; font-size: 40px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <label>Imagen 3:</label>
                                                            <input type="file" name="image3" id="image3" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                                        </div>
                                                        <div class="col-md-4" style="padding-top: 30px;">
                                                            <input type="checkbox" value="1" name="eliminar3" id="eliminar3">
                                                            <label class="form-check-label" for="eliminar3">
                                                                Eliminar
                                                            </label>    
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row" style="height: 80px; background: #d9d9d9;">
                                                        <div class="col-md-2">
                                                            @if( !empty($p->img4))
                                                                <img src="{{ Storage::url('property/'.$p->img4) }}" style="height: 80px !important; max-width: 100% !important;">
                                                            @else
                                                                <i class="far fa-image" style="margin-top: 20px; font-size: 40px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <label>Imagen 4:</label>
                                                            <input type="file" name="image4" id="image4" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                                        </div>
                                                        <div class="col-md-4" style="padding-top: 30px;">
                                                            <input type="checkbox" value="1" name="eliminar4" id="eliminar4">
                                                            <label class="form-check-label" for="eliminar4">
                                                                Eliminar
                                                            </label>    
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row" style="height: 80px; background: #d9d9d9;">
                                                        <div class="col-md-2">
                                                            @if( !empty($p->img5))
                                                                <img src="{{ Storage::url('property/'.$p->img5) }}" style="height: 80px !important; max-width: 100% !important;">
                                                            @else
                                                                <i class="far fa-image" style="margin-top: 20px; font-size: 40px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <label>Imagen 5:</label>
                                                            <input type="file" name="image5" id="image5" class="form-control btn-light mb-4" style="margin: 0 !important; padding-bottom: 40px;">
                                                        </div>
                                                        <div class="col-md-4" style="padding-top: 30px;">
                                                            <input type="checkbox" value="1" name="eliminar5" id="eliminar5">
                                                            <label class="form-check-label" for="eliminar5">
                                                                Eliminar
                                                            </label>    
                                                        </div>
                                                    </div>
                                                    @if (!$reservas->isEmpty())
                                                        <div class="row text-left" style="padding-top: 10px;">
                                                            Dado que la propiedad tiene reservas vigentes: Solo se puede modificar su descripción y fotos.
                                                        </div>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top:30px;">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-2 float-right" style="padding:0 !important;">
                                                <a href="/property/{{ $p->id }}" class="btn btn-success btn-block" type="submit">Ver propiedad</a>
                                            </div>
                                            <div class="col-md-2 float-right" style="padding:0 !important;">
                                                
                                            </div>
                                            <div class="col-md-2 float-right" style="padding:0 !important;">
                                                <button class="btn btn-info btn-block" type="submit">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endforeach
                                    <!-- Default form contact -->
                            </div>
            </div>
        </div>  
    </div>
    <!--div class="container property-recomendations">
        <div class="row">
            <div class="col-md-12">
                <h3 class="py-3">También puede interesarte</h3>
            </div>
            {{--@for ($k = 0; $k < 4; $k++)

                @include('includes/home-card')
                
            @endfor--}}
        </div>
    </div>

@endsection