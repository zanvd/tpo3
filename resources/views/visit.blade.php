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
        @foreach($errors->all() as $error)
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
                                            <b>Predviden datum:</b> {{ $visit->planned_date }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <b>Patronažna sestra:</b> {{ $workOrder->performer }}
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <b>Datum izvedbe:</b> {{ $visit->actual_date }}
                                        </div>
                                    </div>
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
                                    <h3 class="panel-title">Pacient</h3>
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
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Meritve</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {{--<b>Ime:</b> {{ $patient->person->name }}--}}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{--<b>Telefon:</b> {{ $patient->person->phone_num }}--}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {{--<b>Priimek:</b> {{ $patient->person->surname }}--}}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{--<b>Naslov:</b> {{ $patient->person->address }}--}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {{--<b>Datum rojstva:</b> {{ $patient->birth_date }}--}}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{--<b>Pošta:</b> {{ $patient->person->post_number }}--}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {{--<b>ZZZS:</b> {{ $patient->insurance_num }}--}}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{--<b>Okoliš:</b> {{ $patient->person->region }}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($children))
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
                                                <td>{{ $child->person->name }}</td>
                                                <td>{{ $child->person->surname }}</td>
                                                <td>{{ $child->birth_date }}</td>
                                                <td>{{ $child->insurance_num }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
                                    <h3 class="panel-title">Ostali obiski</h3>
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
                                        @foreach($visits as $visit)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{  \Carbon\Carbon::createFromFormat('Y-m-d', $visit->planned_date)->format('d.m.Y') }}
                                                </td>
                                                @if($visit->done == 1)
                                                    <td>
                                                        {{  \Carbon\Carbon::createFromFormat('Y-m-d', $visit->actual_date)->format('d.m.Y') }}
                                                    </td>
                                                @else
                                                    <td>Neopravljen</td>
                                                @endif
                                                @if($visit->fixed_visit == 1)
                                                    <td>Obvezen</td>
                                                @else
                                                    <td>Okviren</td>
                                                @endif
                                                @if(!empty($visit->substituion))
                                                    <td>$visit->substitution</td>
                                                @else
                                                    <td>Ni nadomeščanja</td>
                                                @endif
                                                @if($visit->done == 1)
                                                    <td><a href="/obisk/{{ $visit->visit_id }}">Podrobnosti</a></td>
                                                @else
                                                    <td></td>
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
                @if (!empty($medicines))
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
                                            <th>Pakiranje</th>
                                            <th>Tip</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($medicines as $med)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $med->medicine_name }}</td>
                                                <td>{{ $med->medicine_packaging }}</td>
                                                <td>{{ $med->medicine_type }}</td>
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
                                    <h3 class="panel-title">Epruvete</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <b>Rdečih epruvet:</b> {{ $bloodTubes->red }}
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <b>Modrih epruvet:</b> {{ $bloodTubes->blue }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <b>Zelenih epruvet:</b> {{ $bloodTubes->green }}
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <b>Rumenih epruvet:</b> {{ $bloodTubes->yellow }}
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
