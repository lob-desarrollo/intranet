@extends('layouts.app')

@push('css')
    @vite(['resources/css/home.css'])
@endpush

@section('content')
	<div class="bannerHome">
		<div class="bannerCobertura">
			<div class="celdaCobertura">
				<h6 class="encabezado1">OPERADORA LOB</h6>
				<h3 class="encabezado2">Somos una marca mexicana</h3>
				<h3 class="encabezado2">pensada e inspirada en ti.</h3>
				<h5 class="encabezado3">Moda, Calidad, Innovación y Precio</h5>
			</div>
		</div>
		<video id="background-video" autoplay loop muted poster="https://assets.codepen.io/6093409/river.jpg">
			<source src="{{ asset('media/lob.mp4') }}" type="video/mp4" />
		</video>
	</div>

	<section class="pb-4 bg-light">
		<div class="container pb-5">
			<div class="row">
				<div class="col-4">
					<div class="tarjeta">
						<div class="celdaTarjeta">
							<div class="tarjetaIcono">
								<i class="fas fa-sign-language"></i>	
							</div>
							<h2 class="tarjetaTitulo mt-2">Lorem ipsum dolor</h2>
							<div class="tarjetaDescripcion mt-3">
								Quisque dui nisl, eleifend eget augue aliquam, fringilla lobortis odio. Praesent accumsan ligula neque, a pretium dolor mattis auctor.
							</div>
							<a href="#" class="tarjetaEnlace mt-4"><span>Ver más</span></a>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="tarjeta fondoCiudad">
						<div class="celdaTarjeta cubiertaCiudad">
							@isset($parametros['main'])
							<div class="tarjetaIcono">
								<i class="far fa-{{ strtolower($parametros['main']) }}"></i>
							</div>
							<h2 class="tarjetaTitulo mt-2">{{ strtoupper($parametros['weather']) }}</h2>
							<div class="tarjetaTiempo mt-3">
								<div class="tarjetaTemperatura">{{ intval($parametros['temp']) }}&deg;C</div>
								 {{ $parametros['name'] }}, {{ $parametros['country'] }}
							</div>
							<!--a href="#" class="tarjetaEnlace mt-4"><span>Ver más</span></a-->
							@endisset
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="tarjeta">
						<div class="celdaTarjeta">
							<div class="tarjetaIcono">
								<i class="fas fa-shopping-basket"></i>	
							</div>
							<h2 class="tarjetaTitulo mt-2">Lorem ipsum dolor</h2>
							<div class="tarjetaDescripcion mt-3">
								 Quisque dui nisl, eleifend eget augue aliquam, fringilla lobortis odio. Praesent accumsan ligula neque, a pretium dolor mattis auctor.
							</div>
							<a href="#" class="tarjetaEnlace mt-4"><span>Ver más</span></a>
						</div>
					</div>
				</div>
			</div>

			@if (!Auth::guest())
				@if(!empty($parametros['avisos']))
			<div class="row mt-5">
				<div class="col-12 pt-4">
					<h3 class="subtitulo mt-5">Avisos</h3>
					<h2 class="titulo mt-2">Todo lo relevante, al alcance</h2>

				@foreach($parametros['avisos'] as $key=>$value)
					<div class="mt-5">
						<div class="row notificacion">
							<div class="col-1 sinPadding">
								<div class="notificacionImagen">
									<div style="{{ $value['color'] }}">
										<i class="notificacionTextura {{ $value['imagen'] }}"></i>
									</div>
								</div>
							</div>
							<div class="col-9">
								<div class="notificacionDescripcion">
									<div>
										<h3 class="notificacionTitulo">
											{{ $value['titulo'] }}
											<small>{{ $value['fecha'] }}</small>
										</h3>
										{{ $value['resumen'] }}
									</div>
								</div>
							</div>
							<div class="col-2 sinPadding">
								<div class="notificacionBotonera">
									<div>
										<button type="button" data-aviso="{{ $value['id'] }}" data-titulo="{{ cleanstring::cleanForUrl($value['titulo']) }}" class="btnCalendario"><i class="fad fa-hand-point-right"></i> Leer más</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>

			<!--button type="button" class="btnLista">Consultar lista</button-->
				@endif
			@endif
		</div>
	</section>

	<section class="marginTop marginBottom">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<img src="{{ asset('media/03banner.jpg') }}" class="img-fluid" />
				</div>
				<div class="col-6">
					<div class="contenidoTabla">
						<div class="contenidoCeldaVertical">
							<h2 class="titulo2 mt-2">Objetivo General</h2>

							<p class="mt-4">
							Reconocer a nuestro cliente mejor que nadie, con propuestas de moda superiores. Posicionarse como la marca de moda juvenil emblemática de México y motivar a nuestros clientes para que se sientan atractivos, jóvenes y en tendencia.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="conFondo" style="background: url('{{ asset('media/banner.jpg') }}') top right">
		<div class="contenidoConFondo">
			<div class="container">
				<div class="cajaResumenTabla">
					<div>
						

						<h3 class="subtitulo2">Historia</h3>
						<h2 class="titulo2 mt-2">LOB desde 1964</h2>

						<p class="mt-4">
							Operadora Lob es una empresa 100% Mexicana y Tapatía. Dedicada al diseño y comercialización de prendas de vestir. En la actualidad estamos presentes en CASI TODOS los estados de la República Mexicana.
						</p>
						<p>
							LOB nace en 1964.<br />
							En 1973 se abre la primera tienda, en avenida Chapultepec en Guadalajara México; comercializando inicialmente ropa para caballero.<br />
							Después de abrir tres tiendas se inició la línea de Dama.<br />
							En 1978 se le da un cambio al nombre de las tiendas que hast hoy en día todos conocemos, “LOB”.<br />
							1983 Inicia la expansión a otros estados de la república.<br />
							En 1998 se inician operaciones en Costa Rica.<br />
							En 2002 refuerza su operación, trabajando en Sociedad con LOB FOOTWEAR<br />
							En 2012 LOB comienza a hacer ventas por internet.<br />
							En 2007 Nace tarjeta de crédito LOB. 
						</p>

						<!--p class="mt-4">
							<h5 class="firmado">
								Lorem ipsum
								<span>Sed a lectus lacus</span>
							</h5>
						</p-->
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection