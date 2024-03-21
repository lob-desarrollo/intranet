@extends('layouts.app')

@push('css')
    
@endpush

@section('content')
	<section class="paddingTop paddingBottom">
		<div class="container">
			<table id="empresas" class="table table-hover table-centered dt-responsive nowrap w-100">
			    <thead>
			        <tr>
			            <th>ID</th>
			            <th>Empresa</th>
			            <th>Saldo</th>
			            <th>Alta</th>
			            <th>Estatus</th>
			            <th>Acciones</th>
			        </tr>
			    </thead>
			    <tbody>
			    </tbody>
			</table>
		</div>
	</section>
@endsection