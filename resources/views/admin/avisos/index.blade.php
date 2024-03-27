@extends('layouts.app')

@push('css')
    <link href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
	<section class="paddingTop paddingBottom">
		<div class="container">
			<h1 class="titulo2">{{ $parametros['titulo'] }}</h1>
			<p class="mb-5">{{ $parametros['descripcion'] }}</p>

			<div class="text-start">
				<button type="button" id="btnNuevo" class="btn btn-dark"><i class="fal fa-plus me-1"></i> Nuevo</button>
			</div>
			<table id="{{ $parametros['tabla'] }}" class="table table-striped table-hover table-centered dt-responsive nowrap w-100">
			    <thead>
			        <tr>
			        	<th class="table-dark">TITULO</th>
			            <th class="table-dark">CATEGORÍA</th>
			            <th class="table-dark">DESDE</th>
			            <th class="table-dark">HASTA</th>
			            <th class="table-dark">FECHA</th>
			            <th class="table-dark">ACCIONES</th>
			        </tr>
			    </thead>
			    <tbody>
			    </tbody>
			</table>
		</div>
	</section>
	<form id="formdelete" action="" method="post">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="registro_id" id="registro_id" />
    </form>
@endsection

@push('script')
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="{{ asset('js/listas.js').'?r='.time() }}"></script>
    <script>
        (function($) {
            listas.init('{{ $parametros['tabla'] }}', '{{ $parametros['urlLista'] }}', '{{ $parametros['urlNuevo'] }}', '{{ $parametros['urlEditar'] }}');
            @if ($message = Session::get('alerta'))
            listas.alerta({!! $message !!});
            @endif
        })(jQuery);
    </script>
@endpush