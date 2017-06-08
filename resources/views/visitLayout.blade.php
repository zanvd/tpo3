@if (empty($noEdit))
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading main-color-bg">
			@if($role != 'Pacient')
				<a class="pull-right white" href="/obisk/{{ $visit->visit_id }}/uredi" style="color: white;"><span class="glyphicon glyphicon-pencil"></span> Uredi</a>
			@endif
			<h3 class="panel-title">Obisk</h3>
		</div>
		<div class="panel-body">
@endif
			{{-- Visit --}}
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
											{{ 	\Carbon\Carbon::createFromFormat('Y-m-d', $visit->actual_date)->format('d.m.Y') }}
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
										@if($role != 'Pacient')
										<a href="/delovni-nalog/{{ $workOrder->work_order_id }}">Podrobnosti delovnega naloga</a>
										@endif
									</div>
								</div>
							@else
								Podatki o obisku niso bili najdeni.
							@endif
						</div>
					</div>
				</div>
			</div>
			{{-- Visit End --}}
			{{-- Patient --}}
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
								@else
									Podatki o pacientu niso bili najdeni.
								@endif
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="panel-title">
													<a data-toggle="collapse" href="#collapse{{ $visit->visit_id }}">
														<span class="glyphicon glyphicon-heart-empty"></span> Meritve
													</a>
												</h3>
											</div>
											<div id="collapse{{ $visit->visit_id }}" class="panel-collapse collapse">
												<div class="panel-body">
													@if (!empty($patient->measurements))
														@foreach ($patient->measurements as $measurement)
															@if ($loop->iteration % 2 == 1)
																<div class="row">
															@endif
																<div class="col-md-6">
																	<fieldset>
																		<legend style="font-size: 15px; font-weight: bold;">{{ $measurement['description'] }}</legend>
																		<div class="form-group">
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
																		</div>
																	</fieldset>
																</div>
															@if ($loop->iteration % 2 == 0 || $loop->last)
																</div>
															@endif
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
			{{-- Patient End --}}
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
														<a data-toggle="collapse" href="#collapse{{ $visit->visit_id }}-{{ $loop->iteration }}">
															<span class="glyphicon glyphicon-heart-empty"></span> Meritve
														</a>
													</h3>
												</div>
												<div id="collapse{{ $visit->visit_id }}-{{ $loop->iteration }}" class="panel-collapse collapse">
													<div class="panel-body">
														@if (!empty($child->measurements))
															@foreach ($child->measurements as $measurement)
																@if ($loop->iteration % 2 == 1)
																	<div class="row">
																@endif
																	<div class="col-md-6">
																		<fieldset>
																			<legend style="font-size: 15px; font-weight: bold;">{{ $measurement['description'] }}</legend>
																			<div class="form-group">
																				@foreach ($measurement as $input)
																					@if ($loop->count == 1)
																						Meritev še ni bila opravljena.
																					@endif
																					@if ($loop->first)
																						@continue
																					@elseif($input->type == 'radio')
																						{{ $input->input_name }}<br />
																					@elseif ($input->type == 'select')
																						@if ($loop->iteration == 2)
																							<ul>
																						@endif
																						<li>{{ $input->input_name }}</li>
																						@if ($loop->remaining == 1)
																							</ul>
																						@endif
																					@else
																						{{ $input->input_name }}: {{ $input->value }}<br />
																					@endif
																				@endforeach
																			</div>
																		</fieldset>
																	</div>
																@if ($loop->iteration % 2 == 0 || $loop->last)
																	</div>
																@endif
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
						<div class="panel panel-success">
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
										<th>Porabljeno</th>
									</tr>
									</thead>
									<tbody>
									@foreach($medicines as $medicine)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $medicine->medicine_name }}</td>
											<td>{{ $medicine->medicine_packaging }}</td>
											<td>{{ $medicine->medicine_type }}</td>
											<td align="center">@if ($medicine->taken) <span class="glyphicon glyphicon-ok" style="color: green;" ></span> @else <span class="glyphicon glyphicon-remove" style="color: red" ></span> @endif</td>
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
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="panel-title"><span class="glyphicon glyphicon-tint"></span> Epruvete</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 form-group">
										<label style="color:#ff5050">Rdečih epruvet:</label> {{ $bloodTubes['red'] }}
									</div>
									<div class="col-md-6 form-group">
										<label style="color:#cccc00">Rumenih epruvet:</label> {{ $bloodTubes['yellow'] }}
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label style="color:#0099ff">Modrih epruvet:</label> {{ $bloodTubes['blue'] }}
									</div>
									<div class="col-md-6 form-group">
										<label style="color:#009933; margin-right: 10px;">Zelenih epruvet:</label> {{ $bloodTubes['green'] }}
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
@if (empty($noEdit))
		</div>
	</div>
</div>
@endif
