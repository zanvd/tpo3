@extends('layout')

@section('title')
<title>Patronaža</title>
@endsection

@section('content')
<div class="container">
        <div class="jumbotron">
        <form class="article-comment" id="registrationForm" method="POST" name="registrationForm" action="/registracija">
          <h2>Registracija uspešna!</h2>
          <p>Na vaš e-poštni naslov smo vam poslali povezavo za aktivacijo vašega računa. Če sporočila niste prejeli, ga pošljite ponovno s spodnjim obrazcem. </p>
          <div class="col-md-3">
          <input class="form-control" @if(!empty($email)) value ={{$email}} @endif type="email" placeholder="Vnestie e-naslov..." name="email" id="email" required> 
          </div>
          <button class="btn btn-primary" type="submit">Pošlji</button>
        </form>
          
        </div>
      </div>
@endsection