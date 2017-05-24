@extends('layoutLog')

@section('title')
<title>Nov delovni nalog</title>
<?php $activeView = 'novDN' ?>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrapValidator.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nov delovni nalog </h1>
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
@endsection

@section('menu')
		@if ($role == 'Admin')
			@include(menuAdmin)
		@elseif ($role == 'Vodja PS')
			@include(menuVPS)
		@endif
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
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading main-color-bg">
				<h3 class="panel-title">Delovni nalog</h3>
			</div>
			<div class="panel-body">
				<form class="article-comment" id="workorderForm" method="POST" data-toggle="validator" action="/delovni-nalog">
				 	{{ csrf_field() }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Tip obiska</label>
								<select data-live-search="true" class="form-control selectpicker" name="visitTypeId" id="visitType" title="Izberite..." required>
								  	@if( ! empty($visitTypes) )
										@if($role == "Zdravnik")
									  		@foreach($visitTypes as $key => $value)
										  		<option value="{{ $key}}">{{ $value }}</option>
										  	@endforeach
										@else
											@foreach($visitTypes as $key => $value)
											  	<option value="{{ $key}}">{{ $value }}</option>
												@if (($loop->iteration) == 3 )
													@break
												 @endif
											@endforeach
										@endif
								  	@endif
								</select>
						  	</div>

							<div class="form-group">
								<label>Pacient</label>
								<select data-live-search="true" class="form-control selectpicker" name="patientId" id="patient" title="Izberite..." required>
							  		@if( ! empty($patients) )
								  		@foreach($patients as $key => $value)
								  			<option value="{{ $key}}">{{ $value }}</option> <!-- POPRAVI IMENA SPREMENLJIVK -->
								  		@endforeach
								  	@endif
								</select>
						  	</div>

							<div class="form-group hidden" id="newbornForm">
								<label>Novorojenček</label>
								<select data-live-search="true" class="form-control selectpicker" name="newborn[]" id="newborn" title="Izberite..." disable multiple>
									@if( !empty($dependentChildId))
										@foreach($dependentChildId as $key => $value)
											<option value="{{ $key }}">{{ $value }}</option>
										@endforeach
									@endif
								</select>
						  	</div>
					  	</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Datum prvega obiska</label>
								<input type="text" placeholder="Vnesite datum..." name="firstVisit" id="firstVisit" class="form-control date datepicker">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Obveznost</label>
								<select class="form-control selectpicker" name="mandatory" id="mandatory" title="Izberite..." required>
									<option value="1">Obvezen</option>
									<option value="0">Okviren</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Število obiskov</label>
								<input type="number" placeholder="Število obiskov..." min="1" max="10" name="visits" id="visits" class="form-control">
							</div>
						</div>
					</div>
					<div class="hidden" id="visitOptional">
						<div class="row">
							<div class="col-md-12 flex-parent">
							<input class="flex-child2" type="radio" id="radio1" name="schedule" value="1" checked>
								<div class="form-group flex-child">
									<label>Časovni interval med dvema obiskoma (dni)</label>
									<input type="number" min="0" max="365" placeholder="Število dni..."  name="interval" id="intervalDays" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 flex-parent">
							<input class="flex-child2" type="radio" id="radio2" name="schedule" value="2">
								<div class="form-group flex-child">
									<label>Obiski naj bodo opravljeni do</label>
									<input type="text" placeholder="Vnesite datum..." disabled name="finalDate" id="finalDate" class="form-control datepicker">
								</div>
							</div>
						</div>
					</div>
					<div class="row hidden" id="medicineForm">
						<div class="col-md-12">
							<div class="form-group">
								<label>Zdravila</label>
								<select data-live-search="true" class="form-control selectpicker" name="medicine[]" id="medicine" title="Izberite..." multiple disable>
								  @if( ! empty($medicine) )
									  @foreach($medicine as $key => $value)
									  <option value="{{ $key}}">{{ $value }}</option> <!-- POPRAVI IMENA SPREMENLJIVK -->
									  @endforeach
								  @endif
								</select>
							</div>
						</div>
					</div>
					<div class="row hidden" id="bloodForm">
						<div class="col-md-3">
							<div class="form-group">
								<label style="color:#ff5050">Rdečih epruvet</label>
								<input type="number" placeholder="Vnesite število..." min="0" max="50" name="red" id="red" value="0" disable class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label style="color:#0099ff">Modrih epruvet</label>
								<input type="number" placeholder="Vnesite število..." min="0" max="50" name="blue" id="blue" value="0" disable class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label style="color:#cccc00">Rumenih epruvet</label>
								<input type="number" placeholder="Vnesite število..." min="0" max="50" name="yellow" id="yellow" value="0" disable class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label style="color:#009933">Zelenih epruvet</label>
								<input type="number" placeholder="Vnesite število..." min="0" max="50" name="green" id="green" value="0" disable class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="sum" id="sum" disabled value="1">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" style="margin-top:15px;" type="submit">Ustvari</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
@endsection

@section('script')
<script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
<script src="{{ URL::asset('js/workorderValidate.js') }}"></script>
@endsection