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
			<source src="{{ asset('media/lob.mp4') }}" type="video/mp4">
		</video>
	</div>

	<section class="pb-4 bg-light">
		<div class="container">
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
					<div class="tarjeta">
						<div class="celdaTarjeta">
							<div class="tarjetaIcono">
								<i class="fas fa-trophy-alt"></i>
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

			<div class="row mt-5">
				<div class="col-12 pt-4">
					<h3 class="subtitulo mt-5">Lorem ipsum</h3>
					<h2 class="titulo mt-2">Quisque dui nisl, eleifend eget</h2>

					<div class="mt-5">
						<div class="row notificacion">
							<div class="col-1 sinPadding">
								<div class="notificacionImagen">
									<div>
										<img src="https://company.cera-theme.com/wp-content/uploads/sites/14/2021/06/job-company-8-150x150.png" class="img-fluid" />
									</div>
								</div>
							</div>
							<div class="col-9">
								<div class="notificacionDescripcion">
									<div>
										<h3 class="notificacionTitulo">Lorem ipsum dolor sit amet</h3>
										<b>Nunc vel tellus</b> eget tellus condimentum dapibus bibendum vitae ante. Fusce sapien nulla, sagittis nec dapibus et.
									</div>
								</div>
							</div>
							<div class="col-2 sinPadding">
								<div class="notificacionBotonera">
									<div>
										<button type="button" class="btnCalendario"><i class="far fa-clock"></i> Ver más</button>
										<div>04 de Marzo de 2024</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-5">
						<div class="row notificacion">
							<div class="col-1 sinPadding">
								<div class="notificacionImagen">
									<div>
										<img src="https://company.cera-theme.com/wp-content/uploads/sites/14/2021/06/job-company-8-150x150.png" class="img-fluid" />
									</div>
								</div>
							</div>
							<div class="col-9">
								<div class="notificacionDescripcion">
									<div>
										<h3 class="notificacionTitulo">Lorem ipsum dolor sit amet</h3>
										<b>Nunc vel tellus</b> eget tellus condimentum dapibus bibendum vitae ante. Fusce sapien nulla, sagittis nec dapibus et.
									</div>
								</div>
							</div>
							<div class="col-2 sinPadding">
								<div class="notificacionBotonera">
									<div>
										<button type="button" class="btnCalendario"><i class="far fa-clock"></i> Ver más</button>
										<div>04 de Marzo de 2024</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mt-5">
						<div class="row notificacion">
							<div class="col-1 sinPadding">
								<div class="notificacionImagen">
									<div>
										<img src="https://company.cera-theme.com/wp-content/uploads/sites/14/2021/06/job-company-8-150x150.png" class="img-fluid" />
									</div>
								</div>
							</div>
							<div class="col-9">
								<div class="notificacionDescripcion">
									<div>
										<h3 class="notificacionTitulo">Lorem ipsum dolor sit amet</h3>
										<b>Nunc vel tellus</b> eget tellus condimentum dapibus bibendum vitae ante. Fusce sapien nulla, sagittis nec dapibus et.
									</div>
								</div>
							</div>
							<div class="col-2 sinPadding">
								<div class="notificacionBotonera">
									<div>
										<button type="button" class="btnCalendario"><i class="far fa-clock"></i> Ver más</button>
										<div>04 de Marzo de 2024</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<button type="button" class="btnLista">Consultar lista</button>
		</div>
	</section>

	<section class="marginTop marginBottom">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<img src="https://company.cera-theme.com/wp-content/uploads/sites/14/2021/06/andrew-neel-ute2XAFQU2I-unsplash-700x500.jpg" class="img-fluid" />
				</div>
				<div class="col-6">
					<div class="contenidoTabla">
						<div class="contenidoCelda">
							<h3 class="subtitulo2">Lorem ipsum</h3>
							<h2 class="titulo2 mt-2">Quisque dui nisl, eleifend eget</h2>

							<p class="mt-4">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas consequat dignissim lectus, eget sagittis sapien accumsan quis. Nam sed viverra sem. Proin dapibus aliquam lectus non sollicitudin. Sed a lectus lacus. Nunc vel tellus eget tellus condimentum dapibus bibendum vitae ante. Fusce sapien nulla, sagittis nec dapibus et, sagittis non ipsum. In a nisl sed augue iaculis fringilla nec a sem. Etiam commodo dignissim convallis.
							</p>
							<p>
							Vestibulum pulvinar at magna quis condimentum. Pellentesque ut diam laoreet, mollis magna et, pretium orci. Maecenas eget tincidunt lectus. Sed ultrices ipsum sed turpis ornare, eu facilisis sem condimentum. Mauris ultricies ex vel erat suscipit mollis. Etiam aliquet et quam vitae congue. Aenean facilisis mattis odio eget vestibulum. Nullam vulputate est ac consequat molestie. Suspendisse vitae porttitor ligula.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="conFondo homeBg1">
		<div class="contenidoConFondo">
			<div class="container">
				<div class="cajaResumenTabla">
					<div>
						<h2 class="titulo2 mt-2">Quisque dui nisl, eleifend eget</h2>

						<p class="mt-4">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas consequat dignissim lectus, eget sagittis sapien accumsan quis. Nam sed viverra sem. Proin dapibus aliquam lectus non sollicitudin. Sed a lectus lacus. Nunc vel tellus eget tellus condimentum dapibus bibendum vitae ante. Fusce sapien nulla, sagittis nec dapibus et, sagittis non ipsum. In a nisl sed augue iaculis fringilla nec a sem. Etiam commodo dignissim convallis.
						</p>

						<p>
						Vestibulum pulvinar at magna quis condimentum. Pellentesque ut diam laoreet, mollis magna et, pretium orci. Maecenas eget tincidunt lectus. Sed ultrices ipsum sed turpis ornare, eu facilisis sem condimentum. Mauris ultricies ex vel erat suscipit mollis. Etiam aliquet et quam vitae congue. Aenean facilisis mattis odio eget vestibulum. Nullam vulputate est ac consequat molestie. Suspendisse vitae porttitor ligula.
						</p>

						<p class="mt-4">
							<h5 class="firmado">
								Lorem ipsum
								<span>Sed a lectus lacus</span>
							</h5>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection