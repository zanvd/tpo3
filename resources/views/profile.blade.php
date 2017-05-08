@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </h1>
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
@endsection

@section('menu')
			<div class="list-group">
			  <a href="#" class="list-group-item active main-color-bg">
			   <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil
			  </a>
			  <a href="#" class="list-group-item"> <span class="glyphicon glyphicon-key" aria-hidden="true"></span> Sprememba gesla</a>
			</div>
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
			<form class="article-comment" method="POST" action="/spremeni-geslo">
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
					<input class="form-control" type="password" placeholder="Ponovno vnesite novo geslo..." name="password_confirmation" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]{8,64}" required>
				</div>
				@if ($errors->first('password'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
				@endif
				<button class="btn btn-primary" type="submit">Potrdi</button>
			</form>
		</div>
	</div>
@endsection