@extends('layout')

@section('title')
<title>Registracija</title>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrapValidator.min.css') }}">
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Registracija </h1>
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
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
<div class="container">
	<form class="article-comment" id="registrationForm" data-toggle="validator" method="POST" name="registrationForm" action="/register">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-heading main-color-bg">
			    <h3 class="panel-title">Osebni podatki</h3>
			  </div>
			  <div class="panel-body">
			    <div class="row">
			    	<div class="col-md-6">
			    		<div class="form-group">
						  <label>Email </label>
						  <input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" id="email" required>
						</div>
						<div class="form-group">
						  <label>Geslo</label>
							<input class="form-control" type="password" placeholder="Vnestie geslo..." name="password" id="password" pattern="(?=.*[A-Ža-ž])(?=.*\d)[A-Ža-ž\d]" required>
						</div>
						<div class="form-group">
						  <label>Ponovite geslo</label>
							<input class="form-control" type="password" placeholder="Ponovno vnesite geslo..." name="password_confirmation" id="password_confirmation" required>
						</div>
						<div class="form-group">
						  <label>Ime</label>
							<input class="form-control" type="text" placeholder="Vnesite ime..." name="firstname" id="firstname" pattern="[A-Ž][a-ž]+" required>
						</div>
						<div class="form-group">
						  <label>Priimek</label>
							<input class="form-control" type="text" placeholder="Vnesite ime..." name="surname" id="surname" pattern="[A-Ž][a-ž]+" required>
						</div>
						<div class="form-group">
						  <label>Spol</label>
							<div class="form-control flex-parent">
								<input class="flex-child" type="radio" name="sex" value="m">
								<div class="flex-child">Moški</div>
								<input class="flex-child" type="radio" name="sex" value="f">
								<div class="flex-child">Ženska</div>
							</div>
						</div>
			    	</div>
			    	<div class="col-md-6">
			    		<div class="form-group">
						  <label>Datum rojstva </label>
						  	<div class='input-group date'>
			                    <input type='text' name="birthDate" id="birthDate" placeholder="Vnesite datum oblike dd.mm.yyyy" class="form-control" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
						</div>
						<div class="form-group">
						  <label>Naslov</label>
							<input class="form-control" type="text" placeholder="Vnesite naslov..." name="address" id ="address" required>
						</div>
						<div class="form-group">
						  <label>Poštna številka</label>
							<select  data-live-search="true" class="form-control selectpicker" name="postNumber" id="postNumber" title="Izberite..." required>
							  @if( ! empty($posts) )
									  @foreach($posts as $key => $value)
										<option value="{{ $key }}">{{ $key . ' ' . $value }}</option>
									  @endforeach
							  @endif
							</select>
						</div>
						<div class="form-group">
						  <label>Šifra okoliša</label>
							<select id="region" data-live-search="true" class="form-control selectpicker" name="region" id="region" title="Izberite..." required>
							  @if( ! empty($regions) )
									  @foreach($regions as $key => $value)
										<option value="{{ $key}}">{{ $value }}</option>
									  @endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
						  <label>Telefon</label>
							<input class="form-control" type="text" placeholder="Vnesite vašo telefonsko številko..." name="phoneNumber" id="phoneNumber" pattern="[0-9]{8,9}" required>
						</div>
						<div class="form-group">
						  <label>Številka zdravstvene kartice</label>
							<input class="form-control" type="text" placeholder="Vnesite ZZZS številko..." name="insurance" id="insurance" pattern="[0-9]{9}" required>
						</div>
			    	</div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
	<div class="row collapse" id="contactField">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Kontaktna oseba</h3>
				</div>
				<div class="panel-body">
					<div class="row">
				    	<div class="col-md-6">
				    		<div class="form-group">
								<label>Sorodstveno razmerje</label>
								<select id="relationship" data-live-search="true" class="form-control selectpicker" name="relationship" title="Izberite..." required>
								  @if( ! empty($relationships) )
										  @foreach($relationships as $key => $value)
											<option value="{{ $key}}">{{ $value }}</option>
										  @endforeach
									@endif
								</select>
							</div>
					 		<div class="form-group">
								<label>Ime</label>
									<input class="form-control" type="text" placeholder="Vnesite ime..." name="contactName" id="name" pattern="[A-Ž][a-ž]+" required>
							</div>
							<div class="form-group">
								<label>Priimek</label>
									<input class="form-control" type="text" placeholder="Vnesite ime..." name="contactSurname" id="surname" pattern="[A-Ž][a-ž]+" required>
							</div>
				    	</div>
				    	<div class="col-md-6">
				    		<div class="form-group">
							  <label>Naslov</label>
								<input class="form-control" type="text" placeholder="Vnesite naslov..." name="contactAddress" id="address" required>
							</div>
							<div class="form-group">
							  <label>Poštna številka</label>
								<select  data-live-search="true" class="form-control selectpicker" name="contactPost" id="postNumber" title="Izberite..." required>
								  @if( ! empty($posts) )
										  @foreach($posts as $key => $value)
											<option value="{{ $key }}">{{ $key . ' ' . $value }}</option>
										  @endforeach
								  @endif
								</select>
							</div>
							<div class="form-group">
							  <label>Telefon</label>
								<input class="form-control" type="text" placeholder="Vnesite telefonsko številko..." name="contactPhone" id="phoneNumber" pattern="[0-9]{8,9}" required>
							</div>
				    	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="dependantArea" id="dependantArea">
	<div class="row collapse" id="dependant">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Oseba za katero skrbim</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Sorodstveno razmerje</label>
								<select id="relationship" data-live-search="true" class="form-control selectpicker" name="dependantRelationship[]" id="relationship" title="Izberite..." required>
								  @if( ! empty($relationships) )
										  @foreach($relationships as $key => $value)
											<option value="{{ $key}}">{{ $value }}</option>
										  @endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label>Ime</label>
									<input class="form-control" type="text" placeholder="Vnesite ime..." name="dependantName[]" id="name" pattern="[A-Ž][a-ž]+" required>
							</div>
							<div class="form-group">
								<label>Priimek</label>
									<input class="form-control" type="text" placeholder="Vnesite ime..." name="dependantSurname[]" id="surname" pattern="[A-Ž][a-ž]+" required>
							</div>
							<div class="form-group">
							  <label>Spol</label>
								<div class="form-control flex-parent">
									<input class="flex-child" type="radio" name="dependantGender[]" value="m">
									<div class="flex-child">Moški</div>
									<input class="flex-child" type="radio" name="dependantGender[]" value="f">
									<div class="flex-child">Ženska</div>
								</div>
							</div>
							<div class="form-group">
							  <label>Datum rojstva </label>
							  	<div class='input-group date'>
				                    <input type='text' name="dependantBirthDate[]" placeholder="Vnesite datum oblike dd.mm.yyyy" id="birthDate" class="form-control" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							  <label>Naslov</label>
								<input class="form-control" type="text" placeholder="Vnesite naslov..." name="dependantAddress[]" id="address" required>
							</div>
							<div class="form-group">
							  <label>Poštna številka</label>
								<select  data-live-search="true" class="form-control selectpicker" name="dependantPostNumber[]" id="postNumber" title="Izberite..." required>
								  @if( ! empty($posts) )
										  @foreach($posts as $key => $value)
											<option value="{{ $key }}">{{ $key . ' ' . $value }}</option>
										  @endforeach
								  @endif
								</select>
							</div>
							<div class="form-group">
							  <label>Šifra okoliša</label>
								<select id="region" data-live-search="true" class="form-control selectpicker" name="dependantRegion[]" id="region" title="Izberite..." required>
								  @if( ! empty($regions) )
										  @foreach($regions as $key => $value)
											<option value="{{ $key}}">{{ $value }}</option>
										  @endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
							  <label>Številka zdravstvene kartice</label>
								<input class="form-control" type="text" placeholder="Vnesite ZZZS številko..." name="dependantInsurance[]" id="insurance" pattern="[0-9]{9}" required>
							</div>
						</div>
					</div>
					<div class="row">
					    <div class="col-md-6">
					    	<button class="btn btn-danger" onclick="removeSelf(event.target)" type="button">Odstrani</button>
					    </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#contactField" id="addContactPerson">Dodaj kontaktno osebo</button>
			<button class="btn btn-primary" type="button" id="addDependantPerson">Dodaj oskrbovano osebo</button>
			<button class="btn btn-primary" type="submit">Registracija</button>
		</div>
	</div>
	</form>
@endsection

@section('script')
<script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script type="text/javascript">

	$(document).ready(function (){
		/*
		$('.datepicker').datepicker({
		    format: 'dd.mm.yyyy',
		    locale: 'sl'
		});*/
		validate();

	});
</script>
@endsection