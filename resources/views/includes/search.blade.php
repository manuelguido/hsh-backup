<body onload="myFunction()">

<div class="container container-classic">

    <div class="row">
                
                <div class="container-fluid container-classic">
                        <!--Card-->
                        @if(Session::has('error'))                
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('error') }}</strong>
                                <button type="button" class="close text-right" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card home-search">
                
                            <!--Card content-->
                            <div class="card-body">
                
                            <!-- Form -->
                            <form name="make_search" method="get" action="make_search">
                                {{ csrf_field() }}
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
                                        <input id="desde" type="date" class="form-control" name="desde" autofocus required>
                                    
                                    </div>
                                    <div class="col-md-6">
                                        <label>Hasta</label>
                                        <input id="hasta" type="date" class="form-control" name="hasta" autofocus required>
                                        
                                    </div>
                                </div>
                                <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" onclick="tomarUbicacion()">
                                    Buscar por ubicación
                                </button>
                                </p>
                                <div class="collapse" id="collapseExample">
                                
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Provincia</label>
                                            <select required id="provincia" class="form-control" name="provincia" onchange="myFunction()" autofocus>
                                                @foreach ($provincias as $p)
                                                    <option value="{{ $p->id }}" class="provincia_select"> {{ $p->nombre_provincia }}</option>
                                                @endforeach
                                            </select>
                                            @if(Session::has('error_admin_email'))
                                                <span class="help-block">
                                                    <strong class="text-danger">Esta dirección de email ya existe en el sistema</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label>Localidad</label>
                                            @foreach ($provincias as $p)
                                            <select class="form-control localidad_select" id="ciudad" name="ciudad" style="display: none" autofocus>
                                                @foreach ($localidades as $l)
                                                    @if ($l->id_provincia == $p->id)
                                                        <option value="{{ $l->id }}">{{ $l->id }} {{ $l->nombre_localidad }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if(Session::has('error_admin_email'))
                                                <span class="help-block">
                                                    <strong class="text-danger">Esta dirección de email ya existe en el sistema</strong>
                                                </span>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                
                                    <script>
                                        function tomarUbicacion() { 
                                            var a = document.getElementById('tomar_ubicacion').value;
                                            if (a == 0) {
                                                document.getElementById('tomar_ubicacion').value = 1;
                                            }
                                            else {
                                                document.getElementById('tomar_ubicacion').value = 0;
                                            }
                                        }
                                    </script>

                                </div>

                                <br>
                                <div class="form-group row">
                                <div class="col-md-12 text-right"> 
                                    <input id="tomar_ubicacion" type="hidden" class="form-control" value="0" name="tomar_ubicacion" autofocus required>
                                    <button type="submit" class="btn aqua-gradient btn-rounded my-0">Buscar</button>
                                </div>
                                </div>
                
                            </form>
                            <!-- Form -->
                
                            </div>
                
                        </div>
                        <!--/.Card-->
                    </div>
                
        </div>

    </div>