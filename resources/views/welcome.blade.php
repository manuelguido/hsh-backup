@extends('layouts.app')

@section('content')

@if (count($properties) > 0)

    <!--Carousel Wrapper-->
    <div id="carousel-example-2" class="carousel slide home-carousel-height" data-ride="carousel">
            <!--Indicators-->
            <ol class="carousel-indicators">
                
                @php
                    $amountSlides = count($properties);
                @endphp
                
                @for ($i = 0; $i < $amountSlides; $i++)
                    <li data-target="#carousel-example-2" data-slide-to="0" @if ($i==0) class="active" @endif ></li>
                @endfor
            </ol>
            <!--/.Indicators-->
            <!--Slides-->
            <div class="carousel-inner home-carousel-height home-carousel" role="listbox">
                
                @php
                    $j = 0;    
                @endphp

                @foreach ($properties as $p)
                        <a href="/property/{{ $p->id }}" class="carousel-item cursor-p @if ($j==0) active @endif ">
                        @php
                            $j++;
                        @endphp
                        
                        <div class="view cursor-p">
                            <img class="d-block w-100 cursor-p" src="{{ Storage::url('property/'.$p->img1) }}" alt="Imagen de propiedad">
                        <div class="mask rgba-black-light"></div>
                        </div>
                        <div class="carousel-caption">
                        <h3 class="h3-responsive">Light mask</h3>
                        <p>First text</p>
                        </div>
                    </a>
        
                @endforeach
        
            </div>
            <!--/.Slides-->
            <!--Controels-->
            <a class="carousel-control-prev mccp" href="#carousel-example-2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next mccn    " href="#carousel-example-2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                <span class="sr-only">Next</span>
            </a>
            <!--/.Controls-->
        </div>
        <!--/.Carousel Wrapper-->

        @if (!Auth::guest())
            @include('includes.search')
        @endif

        <div class="container-fluid container-classic container-width-60">
        <!-- Container -->
            <div class="row">
                <h2 class="py-3">Descubre tiempos compartidos</h2>
                <!-- Container -->
                <div class="row">
        
                @foreach ($properties as $p)
                                <!-- Column -->
                    <div class="col-md-3 mb-3 d-flex align-items-stretch">
                
                        <!--Card-->
                        <a class="card cursor-p card-home" href="/property/{{ $p->id }}">
                    
                        <p class="btn card-view-over"></p>
            
                        <!--Card image-->
                        <div class="view cursor-p" style="height: 60% !important;">
                            <img class="card-img-top" src="{{ Storage::url('property/'.$p->img1) }}" style="height: 100% !important;">
                            <div class="mask rgba-white-slight"></div>
                        </div>
                    
                        <!--Card content-->
                        <div class="card-body">
                            <!--Title-->
                            <h3 class="card-title">{{ $p->title }}</h3>
                            <p class="ubicacion-card color-blue"><i class="fa fa-map-marker-alt"></i> {{ $p->nombre_localidad }}, {{ $p->nombre_provincia }}</p>
                            
                        </div>
                    
                    </a>
                        <!--/.Card-->
                    
                    </div>
                    <!-- Column -->
        
                @endforeach
            
                </div>
            </div>
        </div>
    </div>

}
@else 
    <br>
    @include('includes.banner', [
        'message' => "El sitio aún no presenta propiedades.",
    ])

@endif

@endsection
