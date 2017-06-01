@extends('layout')

@section('title')
	<title>Patronaža</title>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			@if( $status = Session::get('status'))
				<div class="alert alert-success" role="alert">{{ $status }}</div>
			@endif
			@if (count($errors))
				@foreach($errors->all() as $error)
					<div class="alert alert-danger">{{ $error }}</div>
				@endforeach
			@endif
		</div>
		<div class="jumbotron">

			<form class="article-comment" id="forgottenForm" method="POST" name="forgottenForm" action="/pozabljeno-geslo">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="put">
				<h2>Pozabljeno geslo</h2>
				<p>Vnesite e-poštni naslov, kamor bomo poslali ponastavitveno povezavo.</p>
				<div class="col-md-3">
					<input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" id="email" required>
				</div>
				<button class="btn btn-primary" type="submit">Pošlji</button>
			</form>

		</div>
	</div>
@endsection