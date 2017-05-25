@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
<?php $activeView = 'dodajPacienta' ?>
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
	  	<h1><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Dodaj oskrbovanega pacienta </h1>
	  </div>
	  <div class="col-md-2">
	  </div>
	</div>
	</div>
  </header>
@endsection

@section('menu')
	  @include('menuPatient')
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
  <form class="article-comment" id="registrationForm" method="POST" data-toggle="validator" action="/oskrbovani-pacient">
		{{ csrf_field() }}
 <div class="panel panel-default">
		<div class="panel-heading main-color-bg">
		  <h3 class="panel-title">Oseba za katero skrbim</h3>
		</div>
		<div class="panel-body">
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<label>Sorodstveno razmerje</label>
				<select id="relationship" data-live-search="true" class="form-control selectpicker" name="relationship" id="relationship" title="Izberite..." required>
				  @if( ! empty($relationships) )
					  @foreach($relationships as $key => $value)
					  <option value="{{ $key}}">{{ $value }}</option>
					  @endforeach
				  @endif
				</select>
			  </div>
			  <div class="form-group">
				<label>Ime</label>
				  <input class="form-control" type="text" placeholder="Vnesite ime..." name="name" id="name" pattern="[A-Ž][a-ž]+" required>
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
			  <div class="form-group">
				<label>Datum rojstva </label>
				  <div class='input-group date'>
					  <input type='text' name="birthDate" id="birthDate" placeholder="Vnesite datum oblike dd.mm.yyyy" class="form-control date datepicker" />
					  <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
				  </div>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<label>Naslov</label>
				<input class="form-control" type="text" placeholder="Vnesite naslov..." name="address" id="address" required>
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
				<label>Številka zdravstvene kartice</label>
				<input class="form-control" type="text" placeholder="Vnesite ZZZS številko..." name="insurance" id="insurance" pattern="[0-9]{9}" required>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <button class="btn btn-primary" type="submit">Dodaj pacienta</button>
			</div>
		  </div>
		</div>
	  </div>
  </form>
@endsection

@section('script')
	<script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script src="{{ URL::asset('js/patientValidate.js') }}"></script>
	<script type="text/javascript">
		$('.datepicker').datepicker({
			format: 'dd.mm.yyyy',
			language: 'sl'
		}).on('changeDate', function(e) {
			$('#registrationForm').bootstrapValidator('revalidateField', 'birthDate');
		});
	</script>
@endsection