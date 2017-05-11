@extends('layout')

@section('title')
<title>Patronaža</title>
@endsection

@section('content')
<div class="container">
        <div class="jumbotron">
          @if( ! empty($name) )
          	<h1>Odhajate?!</h1>
	        <p>Če se želite odjaviti pritisnite na gumb.</p>
	        <a class="btn btn-primary btn-lg" href="/odjava" role="button">Odjava</a></p>
            @else
            <h1>Dobrodošli!</h1>
	        <p>Za uporabo aplikacije je potrebna registracija. Če že imate račun, se prijavite.</p>
	        <p><a class="btn btn-primary btn-lg" href="registracija" role="button">Registracija</a>
	        <a class="btn btn-primary btn-lg" href="prijava" role="button">Prijava</a></p>
            @endif
        </div>
      </div>
@endsection