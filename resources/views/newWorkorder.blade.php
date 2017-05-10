@extends('layoutLog')

@section('title')
<title>Nov delovni nalog</title>
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
			  <a href="#" class="list-group-item active main-color-bg">
			   <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nov delovni nalog
			  </a>
			  <a href="#" class="list-group-item"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
			  <a href="#" class="list-group-item"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span>Moj profil</a>
			</div>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Izvajalec</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Šifra izvajalca</label>
						<select id="relationship" data-live-search="true" class="form-control selectpicker" name="institution" id="institution" title="Izberite..." required>
						  @if( ! empty($institutions) )
								  @foreach($institutions as $key => $value)
									<option value="{{ $key}}">{{ $value }}</option>
						  @endforeach
							@endif
						</select>
					</div>
					<div class="form-group">
						<label>Šifra zdravniške dejavnosti</label>
						<select id="relationship" data-live-search="true" class="form-control selectpicker" name="task" id="task" title="Izberite..." required>
						  @if( ! empty($tasks) )
								  @foreach($tasks as $key => $value)
									<option value="{{ $key}}">{{ $value }}</option>
								  @endforeach
							@endif
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Zdravnik</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
								<div class="form-control">
								<label class="radio-inline"><input type="radio" name="employeeType"> Osebni</label>
								<label class="radio-inline"><input type="radio" name="employeeType">Napotni</label>
								<label class="radio-inline"><input type="radio" name="employeeType">NMP</label>
								<label class="radio-inline"><input type="radio" name="employeeType">Nadomestni</label>
								</div>
					</div>
					<div class="form-group">
						<label>Številka zdravnika</label>
							<input class="form-control" type="text" placeholder="Vnesite številko zdravnika..." name="doctorId" id="doctorId" required>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Zavarovana oseba</h3>
				</div>
				<div class="panel-body">

				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading main-color-bg">
					<h3 class="panel-title">Napotnica</h3>
				</div>
				<div class="panel-body">

				</div>
			</div>
		</div>
	</div>
@endsection