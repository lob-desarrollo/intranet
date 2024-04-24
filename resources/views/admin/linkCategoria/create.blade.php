@extends('layouts.app')

@push('css')
@endpush

@section('content')
	<section class="paddingTop paddingBottom">
		<div class="container">
			<h1 class="titulo2">{{ $parametros['titulo'] }}</h1>
			<p class="mb-5">{{ $parametros['descripcion'] }}</p>

			<form id="nuevo" action="{{ $parametros['urlGuardar'] }}" method="post" enctype="multipart/form-data" autocomplete="off">
				@csrf

                @isset($parametros['datos']['categoria'])
                {{ method_field('patch') }}
                @endisset

				<div class="row">
					<div class="col-md-4">
						<label for="categoria">Categoría</label>
						<input type="text" name="categoria" id="categoria" class="form-control" value="{{ old('categoria') ?? $parametros['datos']['categoria'] ?? '' }}" required="true" data-tipo="txt" />
						@if ($errors->has('categoria'))
                            <p class="error">{{ $errors->first('categoria') }}</p>
                        @endif
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-2">
						<div class="form-check form-switch">
						  <input class="form-check-input" type="checkbox" role="switch" name="estatus" id="estatus" value="1" {{ isset($parametros['datos']['estatus']) && $parametros['datos']['estatus']==1?'checked':'' }} \>
						  <label class="form-check-label" for="estatus">Activo</label>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-6">
						<button type="button" data-accion="guardar" class="btn btn-dark"><i class="fas fa-save me-1"></i> Guardar</button>
						<button type="button" data-accion="cancelar" class="btn btn-secondary ms-3"><i class="fal fa-times me-1"></i> Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</section>
@endsection

@push('script')
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('js/listas.js').'?r='.time() }}"></script>
    <script>
        (function($) {
            listas.formulario('{{ $parametros['urlCancelar'] }}');
        })(jQuery);
    </script>
@endpush