@extends('layout')

@section('title')
<title>Prijava</title>
@endsection

@section('header')
<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<h1><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Prijava </h1>
			</div>
			<div class="col-md-2">
			</div>
		</div>
	</div>
</header>
@endsection

@section('content')
<div class="container">
        <div class="row">
          <div class="col-md-6">
            @if (count($errors))
                    @foreach($errors->all() as $error)
                      <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
            @endif    
            <div class="panel panel-default">
              <div class="panel-body">
				  <form class="article-comment" method="POST" action="/prijava">
				  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="formEmail">Email</label>
                    <input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" id="formEmail" required>
                  </div>
                  <div class="form-group">
                    <label for="formPassword">Geslo</label>
                    <input class="form-control" type="password" placeholder="Vnestie geslo..." name="password" id="formPassword" required>
                  </div>
                  <button class="btn btn-primary" type="submit">Prijava</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6">
          </div>
      </div>
@endsection
