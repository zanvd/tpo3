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

        <form class="article-comment" id="registrationForm" method="POST" name="registrationForm" action="/verifikacija">
          {{ csrf_field() }}
			<h2>Registracija uspešna!</h2>
          <p>Na vaš e-poštni naslov smo vam poslali povezavo za aktivacijo vašega računa. Če sporočila niste prejeli, ga pošljite ponovno s spodnjim obrazcem. </p>
          <div class="col-md-3">
          <input class="form-control" @if(!empty($email)) value ="{{$email}}" @endif type="email" placeholder="Vnestie e-naslov..." name="email" id="email" required>
          <input type="hidden" name="_method" value="put"> 
          </div>
          <button class="btn btn-primary" type="submit">Pošlji</button>
        </form>
          
        </div>
      </div>
@endsection