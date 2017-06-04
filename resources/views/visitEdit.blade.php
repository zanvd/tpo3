@extends('layoutLog')

@section('script')
	<script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
	<script src="{{ URL::asset('js/visit.js') }}"></script>
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrapValidator.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
	<title>Uredi obisk</title>
	@php $activeView = 'none' @endphp
@endsection

@section('header')
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h1>
						<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Uredi obisk
					</h1>
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
	@if ($status = Session::get('status'))
		<div class="alert alert-success" role="alert">{{ $status }}</div>
	@endif
	@if (count($errors))
		@foreach ($errors->all() as $error)
			<div class="alert alert-danger">{{ $error }}</div>
		@endforeach
	@endif

	<div class="row">
		<ul class="nav nav-pills">
			<li class="active"><a data-toggle="pill" href="#visit1">Obisk 1</a></li>
			<li><a data-toggle="pill" href="#visit2">Obisk 2</a></li>
			<li><a data-toggle="pill" href="#visit3">Obisk 3</a></li>
		</ul>
		<div class="tab-content">
			<div id="visit1" class="tab-pane fade in active">
				@if (!empty($visit))
					<form id="visitEditForm" class="article-comment" method="POST" data-toggle="validator" action="/obisk/{{ $visit->visit_id }}" onsubmit="return confirmDate(this)">
						<input type="hidden" name="_method" value="patch" />
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body">
										@if (!empty($workOrder))
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
													<input type="text" id="actualDate" name="actualDate" class="form-control date datepicker" value="@if ($visit->done == 1) {{ \Carbon\Carbon::createFromFormat('Y-m-d', $visit->actual_date)->format('d.m.Y') }} @endif" placeholder="Vnesite datum..." />
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
													<a href="/delovni-nalog/"{{ $workOrder->work_order_id }}>Podrobnosti delovnega naloga</a>
												</div>
											</div>
										@else
											Podatki o obisku niso bili najdeni.
										@endif
									</div>
								</div>
							</div>
						</div>
						{{-- Pacient --}}
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
										@else
											Podatki o pacientu niso bili najdeni.
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
																	<em>{{ $measurement['description'] }}:</em>
																	<ul>
																		@foreach ($measurement as $input)
																			@if ($loop->first)
																				@continue
																			@elseif ($input->type == 'radio')
																				<input type="radio" name="R-{{ $patient->patient_id }}-{{ $input->measurement_id }}" value="{{ $input->input_id }}" class="form-control" @if ($input->value == 'yes') checked @endif @if ($input->required) required @endif />
																			@elseif ($input->type == 'select')
																				@if ($loop->iteration == 2)
																					<select data-live-search="true" class="form-control selectpicker" name="S-{{ $patient->patient_id }}-{{$input->measurement_id}}[]" multiple @if ($input->required) required @endif >
																						@endif
																						<option value="{{ $input->input_id }}" @if ($input->value == 'yes') selected @endif>{{ $value->name }}</option>
																						@if ($loop->remaining == 1)
																					</select>
																				@endif
																			@elseif ($input->type == 'number')
																				{{ $input->input_name }}: <input type="number" name="{{ $patient->patient_id }}-{{ $input->input_id }}" class="form-control" value="{{ $input->value }}" min="{{ $input->min }}" max="{{ $input->max }}" @if ($input->required) required @endif />
																			@elseif ($input->type == 'date')
																				{{ $input->input_name }}: <input type="text" name="{{ $patient->patient_id }}-{{ $input->input_id }}" class="form-control date datepicker" value="@if ($input->value != 'Meritev še ni bila opravljena.'){{ \Carbon\Carbon::createFromFormat('Y-m-d', $input->value)->format('d.m.Y') }}@endif" @if ($input->required) required @endif />
																			@elseif ($input->type == 'text')
																				{{ $input->input_name }}: <input type="text" name="{{ $patient->patient_id }}-{{ $input->input_id }}" class="form-control" value="{{ $input->value }}" @if ($input->required) required @endif />
																			@endif
																		@endforeach
																	</ul>
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
						{{-- Pacient End --}}
						{{-- Children --}}
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
																			<em>{{ $measurement['description'] }}:</em>
																			<ul>
																				@foreach ($measurement as $input)
																					@if ($loop->first)
																						@continue
																					@elseif ($input->type == 'radio')
																						<input type="radio" name="R-{{ $child->patient_id }}-{{ $input->measurement_id }}" value="{{ $input->input_id }}" class="form-control" @if ($input->value == 'yes') checked @endif @if ($input->required) required @endif />
																					@elseif ($input->type == 'select')
																						@if ($loop->iteration == 2)
																							<select data-live-search="true" class="form-control selectpicker" name="S-{{ $child->patient_id }}-{{$input->measurement_id}}[]" multiple @if ($input->required) required @endif >
																								@endif
																								<option value="{{ $input->input_id }}" @if ($input->value == 'yes') selected @endif>{{ $value->name }}</option>
																								@if ($loop->remaining == 1)
																							</select>
																						@endif
																					@elseif ($input->type == 'number')
																						{{ $input->input_name }}: <input type="number" name="{{ $child->patient_id }}-{{ $input->input_id }}" class="form-control" value="{{ $input->value }}" min="{{ $input->min }}" max="{{ $input->max }}" @if ($input->required) required @endif />
																					@elseif ($input->type == 'date')
																						{{ $input->input_name }}: <input type="text" name="{{ $child->patient_id }}-{{ $input->input_id }}" class="form-control date datepicker" value="@if ($input->value != 'Meritev še ni bila opravljena.'){{ \Carbon\Carbon::createFromFormat('Y-m-d', $input->value)->format('d.m.Y') }}@endif" @if ($input->required) required @endif />
																					@elseif ($input->type == 'text')
																						{{ $input->input_name }}: <input type="text" name="{{ $child->patient_id }}-{{ $input->input_id }}" class="form-control" value="{{ $input->value }}" @if ($input->required) required @endif />
																					@endif
																				@endforeach
																			</ul>
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
						{{-- Children End --}}
						{{-- Medicines --}}
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
												@foreach ($medicines as $medicine)
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
						{{-- Medicines End --}}
						{{-- Blood Tubes --}}
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
						{{-- Blood Tubes End --}}
						<button class="btn btn-primary" type="submit">Shrani</button>
					</form>
				@else
					Podatki o obisku niso bili najdeni.
				@endif
			</div>
			@foreach ($visits as $vis)
				@if ($visit->visit_id != $vis->visit_id)
					<div id="visit2" class="tab-pane fade in">
						Obisk 2
					</div>
				@endif
			@endforeach
		</div>
	</div>
@endsection
