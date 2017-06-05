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
			<form class="article-comment" id="resetForm" method="POST" name="resetForm" action="/ponastavi-geslo">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="put">
				<h2>Ponastavi geslo</h2>
				<p>Vnesite novo geslo.</p>
				<div class="col-md-6">
					<input class="form-control hidden" type="email" name="email" id="email" value="{{ $email }}" required>
					<input class="form-control hidden" type="text" name="token" value="{{ $token }}">
					<div class="form-group">
						<label>Novo geslo</label>
						<input class="form-control" type="password" placeholder="Vnesite novo geslo..." name="password" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]{8,64}" required>
					</div>
					<div class="form-group">
						<label>Ponovitev novega gesla</label>
						<input class="form-control" type="password" placeholder="Ponovno vnesite novo geslo..." name="password_confirmation" required>
					</div>
					<button class="btn btn-primary" type="submit">Pošlji</button>
				</div>
			</form>
		</div>
	</div>
@endsection