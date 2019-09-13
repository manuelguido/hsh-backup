@extends('layouts.app')

@section('title','Propiedad')

@section('content')

<!-- Se declara esto solo para cargar el js de panel -->
<body onload="gallerySwitch(0)">

    <div class="container big-margin">
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
        @foreach ($property as $p)
            <div class="row">
                <div class="col-md-5 overflow-hidden">
                        <div class="row">
                            <div class="col-md-12 property-image fill">
                                @php
                                    $amount_images = 5; //max 5
                                @endphp
                                @if( !empty($p->img1))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img2))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img2) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img3))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img3) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img4))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img4) }}" alt="Imagen de propiedad">
                                @endif
                                @if( !empty($p->img5))
                                <img class="property-img" src="{{ Storage::url('property/'.$p->img5) }}" alt="Imagen de propiedad">
                                @endif
                            </div>
                        </div>
                        <div class="row shadow3 property-subimages">
                                @if( !empty($p->img1))
                                <div class="property-subimage cursor-p" onclick="gallerySwitch(0);">
                                    <img src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                                </div>
                                @endif
                                @if( !empty($p->img2))
                                <div class="property-subimage cursor-p" onclick="gallerySwitch(1);">
                                    <img src="{{ Storage::url('property/'.$p->img2) }}" alt="Imagen de propiedad">
                                </div>
                                @endif
                                @if( !empty($p->img3))
                                <div class="property-subimage cursor-p" onclick="gallerySwitch(2);">
                                    <img src="{{ Storage::url('property/'.$p->img3) }}" alt="Imagen de propiedad">
                                </div>
                                @endif
                                @if( !empty($p->img4))
                                <div class="property-subimage cursor-p" onclick="gallerySwitch(3);">
                                    <img src="{{ Storage::url('property/'.$p->img4) }}" alt="Imagen de propiedad">
                                </div>
                                @endif
                                @if( !empty($p->img5))
                                    <div class="property-subimage cursor-p" onclick="gallerySwitch(4);">
                                        <img src="{{ Storage::url('property/'.$p->img5) }}" alt="Imagen de propiedad">
                                    </div>
                                @endif
                        </div>
                    </div>
                    <div class="col-md-6 offset-1 property-info">
                        <h2>{{ $p->title }}<h2>
                        <hr>
                        <!-- @include('includes/calification') -->
                        <br>
                        <p> {{ $p->description }}</p>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                                                aria-selected="true">Subasta</a>
                                            </li>
                                            <!--li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                                                aria-selected="false">Alquiler</a>
                                            </li>
                                            <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                                                aria-selected="false">HotSale</a>
                                            </li-->
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <!--div class="row">
                                                            <div class="col-md-12 text-left">
                                                                <p>La subasta termina en 1d 4hs </p>
                                                            </div>
                                                    </div-->
                                                    <div class="row">
                                                        <div class="col-md-4 py-2 text-left">
                                                            <label>Fecha</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" id="exampleForm2" class="form-control disabled uns text-center" placeholder="22/10/19 - 29/10/19">
                                                        </div>
                                                    </div>
                                                    <div class="row py-3">
                                                        <div class="col-md-4 py-2 text-left">
                                                            <label>Valor actual</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                        <input type="text" id="exampleForm2" class="form-control disabled uns text-center" placeholder="{{ $p->initial_value }}">
                                                        </div>
                                                    </div>

                                                    <!-- Form -->
                                                    <form method="post" action="/push_bid" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <!-- Heading -->
                                                        <hr>
                                                        <h1 class="dark-grey-text text-left">
                                                            <b>Pujar</b>
                                                        </h1>
                                                        <br>
                                        
                                                        <div class="form-group row text-left">
                                                            <div class="col-md-3">
                                                                <label>Valor</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input id="value" type="number" class="form-control" name="value" autofocus required>
                                                                <input id="id" type="hidden" class="form-control" name="id" value="{{ $p->property_id }}" autofocus required>
                                                                <input id="actual_value" type="hidden" class="form-control" name="actual_value" value="{{ $p->initial_value }}" autofocus required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row text-left">
                                                            <div class="col-md-3">
                                                                <label>Email</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control" name="email" autofocus required>
                                                            </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group row">
                                                            <div class="col-md-9 text-right">
                                                                <button type="submit" class="btn aqua-gradient btn-rounded my-0">Pujar</button>
                                                            </div>
                                                        </div>
                                            
                                                    </form>
                                                    <!-- Form -->

                                            </div>
                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="browser-default custom-select uns">
                                                            @for ($k = 1; $k <= 50; $k++)
                                                                <option value="{{$k}}">01/01/01 - 02/02/02</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                            </div>
                                        </div>
                            </div>
                        </div>
                </div>
            </div>
        @endforeach 
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