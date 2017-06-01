@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('js/visitFilter.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    <title>Seznam obiskov</title>
    <?php $activeView = 'seznamObiskov' ?>
@endsection

@section('header')
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Seznam obiskov</h1>
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
        <div class="panel panel-default filterable">
            <div class="panel-heading main-color-bg">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title">Seznam obiskov</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <h3> <span class="glyphicon glyphicon-filter"></span>  Filtriranje </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Predvideni datum obiska od</label>
                                <input type="text" placeholder="Vnesite datum..." name="dateFrom" id="dateFrom" class="form-control date datepicker">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Predvideni datum obiska do</label>
                                <input type="text" placeholder="Vnesite datum..." name="dateTo" id="dateTo" class="form-control date datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dejanski datum obiska od</label>
                                <input type="text" placeholder="Vnesite datum..." name="dateFromD" id="dateFromD" class="form-control date datepicker">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dejanski datum obiska do</label>
                                <input type="text" placeholder="Vnesite datum..." name="dateToD" id="dateToD" class="form-control date datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Izdajatelj</label>
                                <select  data-live-search="true" class="form-control selectpicker" name="prescribers" id="prescribers" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pacient</label>
                                <select  data-live-search="true" class="form-control selectpicker" name="patients" id="patients" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($role == 'Vodja PS' || $role == 'Zdravnik')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Zadolžena PS</label>
                                <select data-live-search="true" class="form-control selectpicker" name="performers" id="performers" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nadomestna PS</label>
                                <select  data-live-search="true" class="form-control selectpicker" name="substitutions" id="substitutions" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vrsta obiska</label>
                                <select data-live-search="true" class="form-control selectpicker" name="visitTypes" id="visitTypes" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stanje obiska</label>
                                <select data-live-search="true" class="form-control selectpicker" name="visitDone" id="visitDone" title="Izberite..." >
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12" style="margin-top: 10px;">
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th>Preglej</th>
                                    <th>Načrtovan datum</th>
                                    <th>Dejanski datum</th>
                                    <th>Vrsta obiska</th>
                                    <th>Izdajatelj</th>
                                    <th>Pacient</th>
                                    <th>Zadolžena PS</th>
                                    <th>Nadomestna PS</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if( ! empty($visits) )
                                @foreach($visits as $visit)
                                    <tr>
                                        <td>
                                            <a href='/obisk/{{$visit->visit_id}}'>Preglej obisk</a>
                                        </td>
                                        <td id="issued">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $visit->planned_date)->format('d.m.Y')}}</td>
                                        <td id="done">
                                            @php
                                                echo $visit->done == 0
                                                ? 'Neopravljen'
                                                : \Carbon\Carbon::createFromFormat('Y-m-d', $visit->actual_date)->format('d.m.Y');
                                            @endphp
                                        </td>
                                        <td id="visitType">{{$visit->workorder->type}}</td>
                                        <td id="prescriber">{{$visit->prescriber}}</td>
                                        <td id="patient">{{$visit->patient}}</td>
                                        <td id="PS">{{$visit->performer}}</td>
                                        <td id="subPS">
                                            @if( !empty($visit->substitution_id))
                                                {{$visit->substitution}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input id="employeeName" class="hidden" value="{{$name}}">
    </div>
@endsection