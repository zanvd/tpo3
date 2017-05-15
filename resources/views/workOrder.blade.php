@extends('layoutLog')

@section('title')
<title>Preglej delovni nalog</title>
@endsection

@section('header')
<header id="header">
	  <div class="container">
		<div class="row">
		  <div class="col-md-10">
			<h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Preglej delovni nalog </h1>
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
		  	<a href="/delovni-nalog/ustvari" class="list-group-item main-color-bg">
		   		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nov delovni nalog
		  	</a>
		  	<a href="#" class="list-group-item"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
		  	<a href="/spremeni-geslo" class="list-group-item "> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
		</div>
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
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								@if (! empty($workOrder))
								<div class="row">
									<div class="col-md-6">
										<h4>Tip: {{ $workOrder->type }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Izdan: {{ $workOrder->createdAt }}</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<h4>Izdal: {{ $workOrder->prescriber }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Prevzel: {{ $workOrder->preformer }}</h4>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				@if (! empty($patient))
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Pacient</h3>
							</div>
							<div class="panel-body">
								@if (! empty($patient))
								<div class="row">
									<div class="col-md-6">
										<h4>Ime: {{ $patient->name }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Telefon: {{ $patient->phoneNum }}</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<h4>Priimek: {{ $patient->surname }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Naslov: {{ $patient->address }}</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<h4>Datum rojstva: {{ $patient->birthDate }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Pošta: {{ $patient->postNumber }}</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<h4>ZZZS: {{ $patient->insurance }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Okoliš: {{ $patient->region }}</h4>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				@endif
				@if (! empty($children))
				<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Novorojenček</h3>
						</div>
						<div class="panel-body">
						<table class="table">
					        <thead>
					          <tr>
					          	<th>#</th>
					            <th>Ime</th>
					            <th>Priimek</th>
					            <th>Datum rojstva</th>
					            <th>ZZZS</th>
					          </tr>
					        </thead>
					        <tbody>
					        @foreach($children as $child)
					        	<tr>
					        		<td>{{ $loop->iteration }}</td>
					        		<td>{{ $child->name }}</td>
					        		<td>{{ $child->surname }}</td>
					        		<td>{{ $child->birthDate }}</td>
					        		<td>{{ $child->insurance }}</td>
					        	</tr>
					        @endforeach
					        </tbody>
				      	</table>
						</div>
					</div>
				</div>
				</div>
				@endif
				@if (! empty($visits))
				<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Obiski</h3>
						</div>
						<div class="panel-body">
						<table class="table">
					        <thead>
					          <tr>
					          	<th>#</th>
					            <th>Predviden datum</th>
					            <th>Dejanski datum</th>
					            <th>Obveznost</th>
					            <th>Pregled</th>
					          </tr>
					        </thead>
					        <tbody>
					        @foreach($visits as $visit)
					        	<tr>
					        		<td>{{ $loop->iteration }}</td>
					        		<td>{{ $visit->date }}</td>
					        	@if($child->done == 1)
					        		<td>{{ $visit->actualDate }}</td>
					        	@endif
					        	@if($visit->fixed == 1)
					        		<td>obvezen</td>
					        	@else
					        		<td>okviren</td>
					        	@endif
					        	@if($visit->done == 1)
					        		<td><a href="/vist/{{ $visit->visitID }}">Preglej</a></td>
					        	@else
					        	@endif
					        	</tr>
					        @endforeach
					        </tbody>
				      	</table>
						</div>
					</div>
				</div>
				</div>
				@endif
				@if (! empty($medicine))
				<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Zdravila</h3>
						</div>
						<div class="panel-body">
						<table class="table">
					        <thead>
					          <tr>
					          	<th>#</th>
					            <th>Naziv</th>
					          </tr>
					        </thead>
					        <tbody>
					        @foreach($medicine as $med)
					        	<tr>
					        		<td>{{ $loop->iteration }}</td>
					        		<td>{{ $med->name }}</td>
					        	</tr>
					        @endforeach
					        </tbody>
				      	</table>
						</div>
					</div>
				</div>
				</div>
				@endif
				@if (! empty($material))
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Epruvete</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<h4>Rdečih epruvet: {{ $material->red }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Modrih epruvet: {{ $material->blue }}</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<h4>Zelenih epruvet: {{ $material->green }}</h4>
									</div>
									<div class="col-md-6">
										<h4>Rumenih epruvet: {{ $material->yellow }}</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	
@endsection
