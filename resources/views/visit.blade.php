@extends('layoutLog')

@section('title')
	<title>Preglej obisk</title>
	<?php $activeView = 'none' ?>
@endsection

@section('header')
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h1>
						<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Preglej obisk
					</h1>
				</div>
				<div class="col-md-2">
				</div>
			</div>
		</div>
	</header>
@endsection

@section('menu')
	@if ($role == 'Vodja PS')
		@include('menuVPS')
	@elseif ($role == 'Zdravnik')
		@include('menuDoctor')
	@elseif ($role == 'Patronažna sestra')
		@include('menuPS')
	@elseif ($role == 'Pacient')
		@include('menuPatient')
	@endif
@endsection

@section('content')
	@if( $status = Session::get('status'))
		<div class="alert alert-success" role="alert">{{ $status }}</div>
	@endif
	@if (count($errors))
		@foreach ($errors->all() as $error)
			<div class="alert alert-danger">{{ $error }}</div>
		@endforeach
	@endif

	@include('visitLayout')

@endsection
