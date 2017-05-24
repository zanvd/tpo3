@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/workorderFilter.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
@endsection

@section('title')
    <title>Preglej delovni nalog</title>
<?php $activeView = 'seznamDN' ?>
@endsection

@section('header')
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Izdani delovni nalogi </h1>
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
        <div class="panel panel-primary filterable">
            <div class="panel-heading main-color-bg">
            	<div class="row">
            	<div class="col-md-10">
                <h3 class="panel-title">Seznam delovnih nalogov</h3>
                </div>
                <div class="pull-right col-md-2">
                    <button id="filterBtn" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr class="filters" id="filter">
                            <th><input style="display: none;" type="text" id="1" class="form-control" placeholder="#" disabled></th>
                            <th><input style="display: none;" type="text" id="2" class="form-control" placeholder="Izdan" disabled></th>
                            <th><input style="display: none;" type="text" id="3" class="form-control" placeholder="Vrsta obiska" disabled></th>
                            <th><input style="display: none;" type="text" id="4" class="form-control" placeholder="Izdajatelj" disabled></th>
                            <th><input style="display: none;" type="text" id="5" class="form-control" placeholder="Pacient" disabled></th>
                            <th><input style="display: none;" type="text" id="6" class="form-control" placeholder="Zadolžena MS" disabled></th>
                            <th><input style="display: none;" type="text" id="7" class="form-control" placeholder="Nadomestna MS" disabled></th>
                        </tr>
                        <tr class="filters" id="noFilter">
                            <th>Preglej</th>
                            <th>Izdan</th>
                            <th>Vrsta obiska</th>
                            <th>Izdajatelj</th>
                            <th>Pacient</th>
                            <th>Zadolžena MS</th>
                            <th>Nadomestna MS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if( ! empty($workOrders) )
                        @foreach($workOrders as $workOrder)
                            <tr>
                                <td>
                                    <a href='/delovni-nalog/{{$workOrder->work_order_id}}'>#{{$loop->iteration}}</a>
                                </td>
                                <td>{{$workOrder->created_at}}</td>
                                <td>{{$workOrder->visitTitle->visit_subtype_title}}</td>
                                <td>{{$workOrder->prescriber->name . ' ' . $workOrder->prescriber->surname}}</td>
                                <td>
                                    @foreach($workOrder->patients as $pat)
                                        {{$pat->person->name . ' ' . $pat->person->surname}}<br/>
                                    @endforeach
                                </td>
                                <td>{{$workOrder->performer->name . ' ' . $workOrder->performer->surname}}</td>
                                <td>
                                    @if ( !empty ($workOrder->substutution ))
                                        {{$workOrder->substutution->name}}
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
@endsection