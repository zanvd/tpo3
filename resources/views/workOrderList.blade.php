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
        <a href="/delovni-nalog/ustvari" class="list-group-item">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nov delovni nalog
        </a>
        <a href="/delovni-nalog" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
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
                <h3 class="panel-title">Seznam delovnih nalogov</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
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
                                    <a href='/delovni-nalog/{{$workOrder->work_order_id}}'>{{$workOrder->created_at}}</a>
                                </td>
                                <td>{{$workOrder->visitTitle->visit_subtype_title}}</td>
                                <td>{{$workOrder->prescriber->name . ' ' . $workOrder->prescriber->surname}}</td>
                                <td>
                                    @foreach($workOrder->patients as $pat)
                                        {{$pat->person->name}}
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
                        <tr>
                            <td>17.5.2017</td>
                            <td>Obisk nosečnice</td>
                            <td>Zdravnik</td>
                            <td>Mario Špinel</td>
                            <td>Sestra Center</td>
                            <td>Sestra Šiška</td>
                        </tr>
                    </tbody>
                </table>
            {{--</div>--}}
        </div>

@endsection
