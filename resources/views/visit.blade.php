@extends('layoutLog')

@section('title')
	<title>Preglej obisk</title>
	<?php $activeView = 'none' ?>
@endsection

@section('header')
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h1>
						<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Preglej obisk
					</h1>
				</div>
				<div class="col-md-2">
				</div>
			</div>
		</div>
	</header>
@endsection

@section('menu')
	@if ($role == 'Vodja PS')
		@include('menuVPS')
	@elseif ($role == 'Zdravnik')
		@include('menuDoctor')
	@elseif ($role == 'Patronažna sestra')
		@include('menuPS')
	@endif
@endsection

@section('content')
	@if( $status = Session::get('status'))
		<div class="alert alert-success" role="alert">{{ $status }}</div>
	@endif
	@if (count($errors))
		@foreach ($errors->all() as $error)
			<div class="alert alert-danger">{{ $error }}</div>
		@endforeach
	@endif

	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading main-color-bg">
				<h3 class="panel-title">Obisk</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								@if (!empty($visit) && !empty($workOrder))
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Tip:</b> {{ $workOrder->type }}
										</div>
										<div class="col-md-6 form-group">
											<b>Predvideni datum:</b> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $visit->planned_date)->format('d.m.Y') }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Patronažna sestra:</b> {{ $workOrder->performer }}
										</div>
										<div class="col-md-6 form-group">
											<b>Datum izvedbe:</b>
											@if ($visit->done == 1)
												{{ \Carbon\Carbon::createFromFormat('Y-m-d', $visit->actual_date)->format('d.m.Y') }}
											@else
												Neopravljen
											@endif
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Obveznost:</b>
											@php
												echo $visit->fixed_visit ? 'Obvezen' : 'Neobvezen';
											@endphp
										</div>
										<div class="col-md-6 form-group">
											<a href="/delovni-nalog/{{ $workOrder->work_order_id }}">Podrobnosti delovnega naloga</a>
										</div>
									</div>
								@else
									Podatki o obisku niso bili najdeni.
								@endif
							</div>
						</div>
					</div>
				</div>
				@if (!empty($patient))
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Pacient</h3>
								</div>
								<div class="panel-body">
									@if (!empty($patient))
										<div class="row">
											<div class="col-md-6 form-group">
												<b>Ime:</b> {{ $patient->person->name }}
											</div>
											<div class="col-md-6 form-group">
												<b>Telefon:</b> {{ $patient->person->phone_num }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 form-group">
												<b>Priimek:</b> {{ $patient->person->surname }}
											</div>
											<div class="col-md-6 form-group">
												<b>Naslov:</b> {{ $patient->person->address }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 form-group">
												<b>Datum rojstva:</b> {{ $patient->birth_date }}
											</div>
											<div class="col-md-6 form-group">
												<b>Pošta:</b> {{ $patient->person->post_number }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 form-group">
												<b>ZZZS:</b> {{ $patient->insurance_num }}
											</div>
											<div class="col-md-6 form-group">
												<b>Okoliš:</b> {{ $patient->person->region }}
											</div>
										</div>
									@endif
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">
														<a data-toggle="collapse" href="#collapse0">
															<span class="glyphicon glyphicon-heart-empty"></span> Meritve
														</a>
													</h3>
												</div>
												<div id="collapse0" class="panel-collapse collapse">
													<div class="panel-body">
														@if (!empty($patient->measurements))
															@foreach ($patient->measurements as $measurement)
																<div class="panel panel-default">
																	<div class="panel-body">
																		<em>{{ $measurement['description'] }}:</em>
																		<ul>
																			@foreach ($measurement as $input)
																				@if ($loop->count == 1)
																					Meritev še ni bila opravljena.
																				@endif
																				@if ($loop->first)
																					@continue
																				@elseif($input->type == 'radio')
																					{{ $input->value }}<br />
																				@elseif ($input->type == 'select')
																					<li>{{ $input->value }}</li>
																				@else
																					{{ $input->input_name }}: {{ $input->value }}<br />
																				@endif
																			@endforeach
																		</ul>
																	</div>
																</div>
															@endforeach
														@else
															Podatki o meritvah niso bili najdeni.
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
				@if (!empty($children))
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Novorojenčki</h3>
								</div>
								<div class="panel-body">
								@foreach ($children as $child)
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Ime:</b> {{ $child->person->name }}
										</div>
										<div class="col-md-6 form-group">
											<b>Datum rojstva:</b> {{ $child->birth_date }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Priimek:</b> {{ $child->person->surname }}
										</div>
										<div class="col-md-6 form-group">
											<b>ZZZS:</b> {{ $child->insurance_num }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">
														<a data-toggle="collapse" href="#collapse{{ $loop->iteration }}">
															<span class="glyphicon glyphicon-heart-empty"></span> Meritve
														</a>
													</h3>
												</div>
												<div id="collapse{{ $loop->iteration }}" class="panel-collapse collapse">
													<div class="panel-body">
														@if (!empty($child->measurements))
															@foreach ($child->measurements as $measurement)
																<div class="panel panel-default">
																	<div class="panel-body">
																		<em>{{ $measurement['description'] }}:</em>
																		<ul>
																			@foreach ($measurement as $input)
																				@if ($loop->count == 1)
																					Meritev še ni bila opravljena.
																				@endif
																				@if ($loop->first)
																					@continue
																				@elseif($input->type == 'radio')
																					{{ $input->value }}<br />
																				@elseif ($input->type == 'select')
																					<li>{{ $input->value }}</li>
																				@else
																					{{ $input->input_name }}: {{ $input->value }}<br />
																				@endif
																			@endforeach
																		</ul>
																	</div>
																</div>
															@endforeach
														@else
															Podatki o meritvah niso bili najdeni.
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
									@if (!$loop->last)
										<hr />
									@endif
								@endforeach
								</div>
							</div>
						</div>
					</div>
				@endif
				@if (!empty($medicines))
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Zdravila</h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Naziv</th>
												<th>Pakiranje</th>
												<th>Tip</th>
											</tr>
										</thead>
										<tbody>
											@foreach($medicines as $medicine)
												<tr>
													<td>{{ $loop->iteration }}</td>
													<td>{{ $medicine->medicine_name }}</td>
													<td>{{ $medicine->medicine_packaging }}</td>
													<td>{{ $medicine->medicine_type }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endif
				@if (!empty($bloodTubes))
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-tint"></span> Epruvete</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Rdečih epruvet:</b> {{ $bloodTubes['red'] }}
										</div>
										<div class="col-md-6 form-group">
											<b>Modrih epruvet:</b> {{ $bloodTubes['blue'] }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 form-group">
											<b>Zelenih epruvet:</b> {{ $bloodTubes['green'] }}
										</div>
										<div class="col-md-6 form-group">
											<b>Rumenih epruvet:</b> {{ $bloodTubes['yellow'] }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
				@if (!empty($visits))
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> Ostali obiski</h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
										<tr>
											<th>#</th>
											<th>Predvideni datum</th>
											<th>Dejanski datum</th>
											<th>Obveznost</th>
											<th>Nadomeščanje</th>
											<th>Pregled</th>
										</tr>
										</thead>
										<tbody>
										@foreach ($visits as $vis)
											@if ($vis->visit_id == $visit->visit_id)
												@continue
											@endif
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>
													{{ \Carbon\Carbon::createFromFormat('Y-m-d', $vis->planned_date)->format('d.m.Y') }}
												</td>
											@if ($vis->done == 1)
												<td>
													{{ \Carbon\Carbon::createFromFormat('Y-m-d', $vis->actual_date)->format('d.m.Y') }}
												</td>
											@else
												<td>Neopravljen</td>
											@endif
											@if ($vis->fixed_visit == 1)
												<td>Obvezen</td>
											@else
												<td>Okviren</td>
											@endif
											@if (!empty($vis->substituion))
												<td>$vis->substitution</td>
											@else
												<td>Ni nadomeščanja</td>
											@endif
												<td><a href="/obisk/{{ $vis->visit_id }}">Podrobnosti</a></td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endif
				<div class="row">
					<div class="col-md-12">
						<a class="btn btn-primary" href="/obisk/{{ $visit->visit_id }}/uredi">Uredi</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
