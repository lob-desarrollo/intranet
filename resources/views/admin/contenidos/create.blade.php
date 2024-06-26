@extends('layouts.app')

@push('css')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
	<section class="paddingTop paddingBottom">
		<div class="container">
			<h1 class="titulo2">{{ $parametros['titulo'] }}</h1>
			<p class="mb-5">{{ $parametros['descripcion'] }}</p>

			<form id="nuevo" action="{{ $parametros['urlGuardar'] }}" method="post" enctype="multipart/form-data" autocomplete="off">
				@csrf

                @isset($parametros['datos']['id'])
                {{ method_field('patch') }}
                @endisset

				<div class="row">
					<div class="col-md-8">
						@php
							$usuario = old('user_id') ?? $parametros['datos']['user_id'] ?? '';
						@endphp
						<label for="user_id">Nombre</label>
						<select class="form-select" name="user_id" id="user_id" data-placeholder="Selecciona colaborador" required="true" data-tipo="txt">
						    <option></option>
						    @foreach($parametros['usuarios'] as $key=>$value)
						    <option value="{{ $value['user_id'] }}" {{ $value['user_id']==$usuario?'selected="selected"':'' }}>{{ $value['nombres'] }} {{ $value['apellidos'] }}</option>
						    @endforeach
						</select>
						@if ($errors->has('user_id'))
                            <p class="error">{{ $errors->first('user_id') }}</p>
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
						<small>Tamaño: 1320x480 pixeles</small>
					</div>
					<div class="col-md-4">
						<div class="ejemploImg">
							@if(isset($parametros['datos']['imagen']))
							<img id="ejemplo" src="{{ asset('storage/contents/'.$parametros['datos']['imagen']) }}" alt="{{ $parametros['datos']['titulo'] }}" class="img-fluid" />
							@else
							<img id="ejemplo" src="{{ asset('media/imagen_ejemplo.png') }}" alt="Imagen ejemplo" class="img-fluid" />
							@endif
						</div>
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="{{ asset('js/listas.js').'?r='.time() }}"></script>
    <script>
    	var editor;

        (function($) {
            listas.formulario('{{ $parametros['urlCancelar'] }}');
            
            $('#user_id').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );

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
						                      "groups": ["list", "align", "blocks"]
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