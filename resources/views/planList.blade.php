@extends('layoutLog')

@section('title')
    <title>Pregled planov</title>
<?php $activeView = 'pregledPlanov' ?>
@endsection


@section('header')
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Pregled planov </h1>
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

    @foreach($plans as $plan)
    <div class="row">
    <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
            <h3 class="panel-title"> Plan za datum : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $plan->plan_date)->format('d.m.Y')}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>Preglej</th>
                                <th>Planiran datum</th>
                                <th>Prvi obisk</th>
                                <th>Obvezen</th>
                                <th>Vrsta obiska</th>
                                <th>Delovni nalog</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($plan->visits as $visit)
                            <tr>
                                <th><a href="/obisk/{{$visit->visit_id}}"> Odpri obisk</a></th>
                                <th>{{$visit->planned_date}}</th>
                                @if($visit->first_visit == 1)
                                    <th>Da</th>
                                @else
                                    <th>Ne</th>
                                @endif
                                @if($visit->fixed_visit == 1)
                                    <th>Da</th>
                                @else
                                    <th>Ne</th>
                                @endif
                                <th>{{$visit->visit_type}}</th>
                                <th><a href="/delovni-nalog/{{$visit->work_order_id}}"> Odpri delovni nalog</a></th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
    @endforeach

@endsection