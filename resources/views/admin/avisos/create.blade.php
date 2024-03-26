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

                @isset($parametros['datos']['categoria_id'])
                {{ method_field('patch') }}
                @endisset

                <div class="row">
                	<div class="col-md-4">
                		<label for="inicia">Inicio de vigencia</label>
                		<input type="date" name="inicia" id="inicia" class="form-control" value="{{ old('inicia') ?? $parametros['datos']['inicia'] ?? '' }}" required="false" data-tipo="txt" />
                	</div>
                	<div class="col-md-4">
                		<label for="termina">Final de vigencia</label>
                		<input type="date" name="termina" id="termina" class="form-control" value="{{ old('termina') ?? $parametros['datos']['termina'] ?? '' }}" required="false" data-tipo="txt" />
                	</div>
                </div>
				<div class="row mt-3">
					<div class="col-md-4">
						<label for="categoria">Categoría</label>
						<select name="categoria_id" id="categoria_id" class="form-select" required="true" data-tipo="txt">
							<option value="">Selecciona categoría</option>
							@if(!empty($parametros['categorias']))
								@foreach($parametros['categorias'] as $key=>$value)
								<option value="{{ $value['id'] }}" {{ isset($parametros['datos']) && $parametros['datos']['categoria_id']==$value['id']?'selected':'' }}>{{ $value['categoria'] }}</option>
								@endforeach
							@endif
						</select>
						@if ($errors->has('categoria_id'))
                            <p class="error">{{ $errors->first('categoria_id') }}</p>
                        @endif
					</div>
					<div class="col-md-4">
						<label for="titulo">Título</label>
						<input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') ?? $parametros['datos']['titulo'] ?? '' }}" required="true" data-tipo="txt" />
						@if ($errors->has('titulo'))
                            <p class="error">{{ $errors->first('titulo') }}</p>
                        @endif
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-8">
						<label for="resumen">Resumen</label>
						<textarea name="resumen" id="resumen" class="form-control" cols="50" rows="5" required="true" data-tipo="txt">{{ old('resumen') ?? $parametros['datos']['resumen'] ?? '' }}</textarea>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-8">
						<label for="contenido">Contenido</label>
						<textarea name="contenido" id="contenido" class="form-control" cols="50" rows="50" required="true" data-tipo="txt">{{ old('contenido') ?? $parametros['datos']['contenido'] ?? '' }}</textarea>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-4">
						<label for="imagen">Imagen</label>
						<input type="file" name="imagen" id="imagen" class="form-control" {{ !isset($parametros['datos']['imagen'])?'required="true"':'required="false"' }} data-tipo="txt" onchange="listas.imagen(this);" />
					</div>
					<div class="col-md-4">
						<div class="ejemploImg">
							@if(isset($parametros['datos']['imagen']))
							<img id="ejemplo" src="{{ asset('storage/notices/'.$parametros['datos']['imagen']) }}" alt="{{ $parametros['datos']['titulo'] }}" class="img-fluid" />
							@else
							<img id="ejemplo" src="{{ asset('media/imagen_ejemplo.png') }}" alt="Imagen ejemplo" class="img-fluid" />
							@endif
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
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="{{ asset('js/listas.js').'?r='.time() }}"></script>
    <script>
    	var editor;

        (function($) {
            listas.formulario('{{ $parametros['urlCancelar'] }}');
            editor = CKEDITOR.replace('contenido', {
						            	  height:['500px'],
						                  toolbarGroups: [{
						                      "name": "basicstyles",
						                      "groups": ["basicstyles"]
						                    },
						                    {
						                      "name": "links",
						                      "groups": ["links"]
						                    },
						                    {
						                      "name": "paragraph",
						                      "groups": ["list", "blocks"]
						                    },
						                    {
						                      "name": "insert",
						                      "groups": ["insert"]
						                    },
						                    {
						                      "name": "styles",
						                      "groups": ["styles"]
						                    },
						                      { name: 'document',    groups: ['Source', 'mode'] }
						                  ],
						                  // Remove the redundant buttons from toolbar groups defined above.
						                  removeButtons: 'Image,Iframe,Font,Styles,SpecialChar,ExportPdf,Save,NewPage,Preview,Print'
						                });
        })(jQuery);
    </script>
@endpush