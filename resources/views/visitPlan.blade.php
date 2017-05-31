@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('js/visitPlan.js') }}"></script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    <title>Planiranje obiskov</title>
<?php $activeView = 'planObiskov' ?>
<?php $role = 'Patronažna sestra' ?>
@endsection

@section('header')
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Plan obiskov </h1>
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
    <form class="article-comment" id="planForm" data-toggle="validator" method="POST" name="planForm" action="/nacrt-obiskov">
        {{ csrf_field() }}
    <div class="row">
    <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Ustvari nov plan </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Datum obiska </label>
                        <div class='input-group date'>
                            <input type='text' name="planDate" id="planDate" placeholder="" class="form-control date datepicker" />
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-12">
                    <table class="table table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>Preglej</th>
                                <th>Datum obiska</th>
                                <th>Obvezen</th>
                                <th>Vrsta obiska</th>
                                <th>Delovni nalog</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="visitIDs" id="visitIDs" value="">
            <input type="hidden" name="removedVisitIDs" id="removedVisitIDs" value="">
            <input type="hidden" name="planIDs" id="planIDs" value="">
            <div class="row" style="margin-top: 10px">
                <div class="col-md-12">
                    <button class="btn btn-success" type="submit">Shrani</button>
                </div>
            </div>

        </div>
    </div>
    </div>
    </form>
    <div class="row">
    <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Seznam neopravljenih obiskov </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" id="datatable2">
                    <thead>
                        <tr>
                            <th>Preglej</th>
                            <th>Datum obiska</th>
                            <th>Obvezen</th>
                            <th>Vrsta obiska</th>
                            <th>Delovni nalog</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if( ! empty($okvirniBrezPlana) )
                                @foreach($okvirniBrezPlana as $visit)
                                    <tr class="okvirni" id="{{$visit->visit_id}}">
                                        <td><a href="/obisk/{{$visit->visit_id}}">Odpri obisk</a></td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->plannedDate)->format('d.m.Y')}}</td>
                                        @if($visit->fixedVisit == 0)
                                            <td>Ne</td>
                                        @else
                                            <td>Da</td>
                                        @endif
                                        <td>{{$visit->visitTitle}}</td>
                                        <td><a href="/delovni-nalog/{{$visit->workOrderId}}">Odpri delovni nalog</a></td>
                                    </tr>
                                @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
        <div class="row hidden">
                <div class="col-md-12">
                    <table id="okvirni2">
                    @if( ! empty($okvirniVPlanu) )
                                @foreach($okvirniVPlanu as $visit)
                                    <tr>
                                        <td>{{$visit->visit_id}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->plannedDate)->format('d.m.Y')}}</td>
                                        @if($visit->fixedVisit == 0)
                                            <td>Ne</td>
                                        @else
                                            <td>Da</td>
                                        @endif
                                        <td>{{$visit->visitTitle}}</td>
                                        <td>{{$visit->workOrderId}}</td>
                                        <td>{{$visit->planID}}</td>
                                    </tr>
                                @endforeach
                    @endif
                    </table>
                </div>
        </div>
        <div class="row hidden">
                <div class="col-md-12">
                    <table id="obvezni">
                    @if( ! empty($obvezniBrezPlana) )
                                @foreach($obvezniBrezPlana as $visit)
                                    <tr>
                                        <td>{{$visit->visit_id}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->plannedDate)->format('d.m.Y')}}</td>
                                        @if($visit->fixedVisit == 0)
                                            <td>Ne</td>
                                        @else
                                            <td>Da</td>
                                        @endif
                                        <td>{{$visit->visitTitle}}</td>
                                        <td>{{$visit->workOrderId}}</td>
                                    </tr>
                                @endforeach
                    @endif
                    </table>
                </div>
        </div>
        <div class="row hidden">
                <div class="col-md-12">
                    <table id="obvezni2">
                    @if( ! empty($obvezniVPlanu) )
                                @foreach($okvirniVPlanu as $visit)
                                    <tr>
                                        <td>{{$visit->visit_id}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $visit->plannedDate)->format('d.m.Y')}}</td>
                                        @if($visit->fixedVisit == 0)
                                            <td>Ne</td>
                                        @else
                                            <td>Da</td>
                                        @endif
                                        <td>{{$visit->visitTitle}}</td>
                                        <td>{{$visit->workOrderId}}</td>
                                        <td>{{$visit->planID}}</td>
                                    </tr>
                                @endforeach
                    @endif
                    </table>
                </div>
        </div>
    </div>
@endsection