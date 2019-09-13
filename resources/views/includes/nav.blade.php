<!-- Nav fixed -->
<nav class="navbar navbar-inverse navbar-expand-xl fixed-top">
	<div class="navbar-header d-flex col">
	<a href="/"><img src="{{ asset('img/logos/HSH-Logo.svg') }}"></a>	
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	@if (!Auth::guest())
		<a href="/properties" class="btn btn-outline-default waves-effect nav-item" style="padding: 10px 60px !important;">Ver residencias</a>
		
	@endif
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">		
		
		@if (!Auth::guest())
		<!--a href="/home" class="btn btn-info">Buscar <i class="fas fa-search"></i></a-->
		@endif
		
		<ul class="nav navbar-nav navbar-right ml-auto">
			<!-- Authentication Links -->
			@if (Auth::guest())
				
					<li><a href="{{ route('login') }}">Iniciar sesión</a></li>
					<li><a href="{{ route('register') }}">Registrarse</a></li>

			@else
			
			<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ Auth::user()->name }} <span class=""></span>
					</a>

					<div class="dropdown-menu" role="menu">
						
						
							<a class="dropdown-item" href="/profile/{{ Auth::user()->id }}">
								<i class="fas fa-user-circle"></i>Perfil
							</a>
						
						
							<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
										 document.getElementById('logout-form').submit();">
								<i class="fas fa-power-off"></i> Cerrar sesión
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						
						</div>
				</li>
			@endif
		</ul>
    </div>    
</nav>