@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
<?php $activeView = 'dodajUporabnika' ?>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrapValidator.min.css') }}">
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ustvari profil </h1>
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
@endsection

@section('menu')
	@include('menuAdmin')
@endsection

@section('content')
	@if( $status = Session::get('status'))
		<div class="alert alert-success" role="alert">{{ $status }}</div>
	@endif
		<div class="panel panel-default">
			  <div class="panel-heading main-color-bg">
				<h3 class="panel-title">Nov uporabnik</h3>
			  </div>
			  <div class="panel-body">
				<form class="article-comment" id="registrationForm" method="POST" data-toggle="validator" action="/registracija/zaposleni">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="function">Funkcija: </label>
					<div class="form-control flex-parent">
						@if( ! empty($roles) )
							@foreach($roles as $key => $value)
								@if (!$loop->first && !$loop->last)
									<label class="radio-inline flex-child"
									   @if ($loop->index == 1 || $loop->index == 2)
											onclick="disableField()">
										@else
											onclick="enableField()">
										@endif
										<input type="radio" name="function" value={{ $key }} @if ($loop->index == 1) checked="checked" @endif >
										{{ $value }}
									</label>
								@endif
							@endforeach
						@endif
					</div>
				</div>
				<div class="form-group">
				  <label>Email: </label>
				  <input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" required>
				</div>
				@if ($errors->first('email'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
				@endif
				<div class="form-group">
				  <label>Geslo</label>
					<input class="form-control" type="password" placeholder="Vnestie geslo..." name="password" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]{8,64}" required>
				</div>
				<div class="form-group">
				  <label>Ponovite geslo</label>
					<input class="form-control" type="password" placeholder="Ponovno vnesite geslo..." name="password_confirmation" required>
				</div>
				@if ($errors->first('password'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
				@endif
				<div class="form-group">
				  <label>Ime</label>
					<input class="form-control" type="text" placeholder="Vnesite ime..." name="name" pattern="[A-Ž][a-ž]+" required>
				</div>
				@if ($errors->first('name'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
				@endif
				<div class="form-group">
				  <label>Priimek</label>
					<input class="form-control" type="text" placeholder="Vnesite ime..." name="surname" pattern="[A-Ž][a-ž]+" required>
				</div>
				@if ($errors->first('surname'))
					<div class="alert alert-danger" role="alert">{{ $errors->first('surname') }}</div>
				@endif
				<div class="form-group">
				  <label>Telefon</label>
					<input class="form-control" type="text" placeholder="Vnesite vašo telefonsko številko..." name="phoneNumber" pattern="[0-9]{8,9}" required>
				</div>
				<div class="form-group">
				  <label>Naslov</label>
					<input class="form-control" type="text" placeholder="Vnesite naslov..." name="address" required>
				</div>
				<div class="form-group">
				  <label>Poštna številka</label>
					<select  data-live-search="true" class="form-control selectpicker" name="postNumber" title="Izberite..." required>
					  @if( ! empty($posts) )
							  @foreach($posts as $key => $value)
								<option value="{{ $key }}">{{ $key . ' ' . $value }}</option>
							  @endforeach
					  @endif
					</select>

				</div>
				<div class="form-group">
				  <label>Šifra izvajalca</label>
					<select  data-live-search="true" class="form-control selectpicker" name="institution" title="Izberite..." required>
					  @if( ! empty($institutions) )
							  @foreach($institutions as $key => $value)
								<option value="{{ $key}}">{{ $value }}</option>
							  @endforeach
					  @endif
					</select>
				</div>
				<div class="form-group">
				  <label>Šifra okoliša</label>
					<select id="region" data-live-search="true" class="form-control selectpicker" name="region" title="Izberite..." disabled required>
					  @if( ! empty($regions) )
							  @foreach($regions as $key => $value)
								<option value="{{ $key}}">{{ $value }}</option>
							  @endforeach
						@endif
					</select>
				</div>
				<button class="btn btn-primary" type="submit">Ustvari</button>
				</form>
			  </div>
			</div>
@endsection

@section('script')
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script src="{{ URL::asset('js/registerValidate.js') }}"></script>
@endsection