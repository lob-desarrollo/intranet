@extends('layouts.app')

@push('css')
    @vite(['resources/css/avisos-categoria.css'])
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
					<div class="col-md-2">
						<label for="imagen">Estatus</label>
						<div class="form-check form-switch mt-2">
						  <input class="form-check-input" type="checkbox" role="switch" name="estatus" id="estatus" value="1" {{ isset($parametros['datos']['estatus']) && $parametros['datos']['estatus']==1?'checked':'' }} \>
						  <label class="form-check-label" for="estatus">Activo</label>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-2">
						<label for="imagen">Icono</label>
						<input type="hidden" name="imagen" id="imagen" value="{{ old('imagen') ?? $parametros['datos']['imagen'] ?? 'fa fa-robot' }}" required="true" data-tipo="txt" />
						<div>
							<button type="button" id="btnIconos" class="btn btn-dark"><i class="{{ old('imagen') ?? $parametros['datos']['imagen'] ?? 'fa fa-robot' }}"></i></button>
						</div>
					</div>
					<div class="col-md-2">
						<label for="color">Color</label>
						<div>
							<input type="color" name="color" id="color" class="form-control form-control-color" value="{{ old('color') ?? $parametros['datos']['color'] ?? '#7bed9f' }}" required="true" data-tipo="txt" />
						</div>
						@if ($errors->has('color'))
                            <p class="error">{{ $errors->first('color') }}</p>
                        @endif
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

	<div id="iconosModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iconos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                	<div class="cajaIconos">
                		@foreach($parametros['iconos'] as $key=>$value)
                		<button type="button" class="btnicono" data-icon="{{ $value }}"><i class="{{ $value }}"></i></button>
                		@endforeach
                	</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
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