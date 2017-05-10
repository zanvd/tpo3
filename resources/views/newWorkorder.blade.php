@extends('layoutLog')

@section('title')
<title>Nov delovni nalog</title>
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
			<h1><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nov delovni nalog </h1>
		  </div>
		  <div class="col-md-2">
		  </div>
		</div>
	  </div>
	</header>
@endsection

@section('menu')
			<div class="list-group">
			<a href="#" class="list-group-item"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span>Moj profil</a>
			  <a href="#" class="list-group-item active main-color-bg">
			   <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nov delovni nalog
			  </a>
			  <a href="#" class="list-group-item"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
			  <a href="/spremeni-geslo" class="list-group-item "> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
			</div>
@endsection

@section('content')
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading main-color-bg">
				<h3 class="panel-title">Delovni nalog</h3>
			</div>
			<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
						<div class="form-group">
		                <label>Tip obiska</label>
		                <select data-live-search="true" class="form-control selectpicker" name="vistiType" id="vistiType" title="Izberite..." required>
		                  @if( ! empty($vistiTypes) )
		                      @foreach($visitTypes as $key => $value)
		                      <option value="{{ $key}}">{{ $value }}</option>
		                      @endforeach
		                  @else
		                  	<option value="1">Obisk nosečnice</option>
		                  	<option value="2">Obisk nosečnice in otroka</option>
		                  	<option value="3">Preventiva starostnika</option>
		                  	<option value="4">Aplikacija inekcij</option>
		                  	<option value="5">Odvzem krvi</option>
		                  	<option value="6">Kontrola zdravstvenega stanja</option>
		                  @endif

		                </select>
		              </div>		

						<div class="form-group">
		                <label>Pacient</label>
		                <select data-live-search="true" class="form-control selectpicker" name="patient" id="patient" title="Izberite..." required>
		                  @if( ! empty($patients) )
		                      @foreach($patients as $key => $value)
		                      <option value="{{ $key}}">{{ $value }}</option> <!-- POPRAVI IMENA SPREMENLJIVK -->
		                      @endforeach
		                  @endif
		                </select>
		              </div>		


						<div class="form-group">
		                <label>Novorojenček</label>
		                <select data-live-search="true" class="form-control selectpicker" name="newborn" id="newborn" title="Izberite..." required>
		                  @if( ! empty($patients) )
		                      @foreach($patients as $key => $value)
		                      <option value="{{ $key}}">{{ $value }}</option> <!-- POPRAVI IMENA SPREMENLJIVK -->
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
							<input type="text" placeholder="Vnesite datum..." class="form-control datepicker">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
		                	<label>Obveznost</label>
							<select class="form-control selectpicker" name="mandatory" id="mandatory" title="Izberite..." required>
								<option value="yes">Obvezen</option>
								<option value="no">Okviren</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
		                	<label>Število obiskov</label>
							<input type="text" placeholder="Število obiskov..." name="visits" name="visits" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 flex-parent">
					<input class="flex-child2" type="radio" name="schedule" value="1">
						<div class="form-group flex-child">
		                	<label>Časovni interval med dvema obiskoma</label>
							<input type="text" name="interval" placeholder="Število dni..." name="interval" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 flex-parent">
					<input class="flex-child2" type="radio" name="schedule" value="1">
						<div class="form-group flex-child">
		                	<label>Obiski naj bodo opravljeni do</label>
							<input type="text" placeholder="Vnesite datum..." class="form-control datepicker">
						</div>
					</div>
				</div>
              	<div class="row">
              		<div class="col-md-12">
              			<div class="form-group">
		                	<label>Zdravila</label>
							<select data-live-search="true" class="form-control selectpicker" name="medicine" id="medicine" title="Izberite..." medicine required>
			                  @if( ! empty($medicine) )
			                      @foreach($medicine as $key => $value)
			                      <option value="{{ $key}}">{{ $value }}</option> <!-- POPRAVI IMENA SPREMENLJIVK -->
			                      @endforeach
			                  @endif
			                </select>
						</div>
              		</div>
              	</div>
              	<div class="row">
              		<div class="col-md-6">
              			<div class="form-group">
		                	<label>Odvzem krvi</label>
							<label> Rdeča eproveta<input type="text" placeholder="Vnesite datum..." class="form-control datepicker"></label>
						</div>
              		</div>
              	</div>


            </div>
		</div>
	</div>
	
@endsection

@section('script')
<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
<script src="{{ URL::asset('js/workorderValidate.js') }}"></script>
@endsection