@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
<?php $activeView = 'spremeniGeslo' ?>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrapValidator.min.css') }}">
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Sprememba gesla  </h1> 
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
@endsection

@section('menu')
	@if ($role == 'Pacient')
		@include('menuPatient')
	@elseif ($role == 'Admin')
		@include('menuAdmin')
	@elseif ($role == 'Vodja PS')
		@include('menuVPS')
	@elseif ($role == 'Zdravnik')
		@include('menuDoctor')
	@elseif ($role == 'Patronažna sestra')
		@include('menuPS')
	@else
		@include('menuEmployee')
	@endif
@endsection

@section('content')
	@if( $status = Session::get('status'))
		<div class="alert alert-success" role="alert">{{ $status }}</div>
	@endif
	@if (count($errors))
		@foreach($errors->all() as $error)
			<div class="alert alert-danger">{{ $error }}</div>
		@endforeach					
	@endif
	<div class="panel panel-default">
		<div class="panel-heading main-color-bg">
			<h3 class="panel-title">Sprememba gesla</h3>
		</div>
		<div class="panel-body">
			<form class="article-comment" id="passwordForm" method="POST" action="/spremeni-geslo">
			<input type="hidden" name="_method" value="put"> 
				{{ csrf_field() }}
				<div class="form-group">
					<label>Staro geslo</label>
					<input class="form-control" type="password" placeholder="Vnesite staro geslo..." name="oldPassword" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]{8,64}" required>
				</div>
				<div class="form-group">
					<label>Novo geslo</label>
					<input class="form-control" type="password" placeholder="Vnesite novo geslo..." name="password" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]{8,64}" required>
				</div>
				<div class="form-group">
					<label>Ponovitev novega gesla</label>
					<input class="form-control" type="password" placeholder="Ponovno vnesite novo geslo..." name="password_confirmation" required>
				</div>
				@if ($errors->first('password'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
				@endif
				<button class="btn btn-primary" type="submit">Potrdi</button>
			</form>
		</div>
	</div>
@endsection

@section('script')
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script type="text/javascript">
function validate() {
	validator = $("#passwordForm").bootstrapValidator({
				fields: {
					oldPassword : {
						validators: {
							notEmpty: {
								message: "Vnesite geslo"
							},
							stringLength: {
								min: 8,
								max: 64,
								message: "Geslo mora biti dolgo vsaj 8 znakov"
							},
							regexp: {
								message: "Geslo mora vsebovati črke in številke"
							}
						}
					},
					password : {
						validators: {
							notEmpty: {
								message: "Vnesite geslo"
							},
							stringLength: {
								min: 8,
								max: 64,
								message: "Geslo mora biti dolgo vsaj 8 znakov"
							},
							regexp: {
								message: "Geslo mora vsebovati črke in številke"
							}
						}
					},
					password_confirmation: {
						validators: {
							notEmpty: {
								message: "Ponovno vnesite geslo"
							},
							identical: {
								field: "password",
								message: "Gesli se morata ujemati"
							}
						}
					}

				}
			});
}
var body = document.getElementsByTagName("BODY")[0];
body.onload = function(){
	validate();
};
</script>
@endsection
