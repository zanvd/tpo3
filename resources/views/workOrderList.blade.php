@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/workorderFilter.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
@endsection

@section('title')
    <title>Preglej delovni nalog</title>
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
        <div class="panel panel-primary filterable">
            <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Seznam delovnih nalogov</h3>
                <div class="pull-right">
                    <button id="filterBtn" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr class="filters">
                            <th><input type="text" class="form-control" placeholder="#" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Izdan" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Vrsta obiska" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Izdajatelj" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Pacient" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Zadolžena MS" disabled></th>
                            <th><input type="text" class="form-control" placeholder="Nadomestna MS" disabled></th>
                        </tr>
                        {{--<tr class="filters">--}}
                            {{--<th>Preglej</th>--}}
                            {{--<th>Izdan</th>--}}
                            {{--<th>Vrsta obiska</th>--}}
                            {{--<th>Izdajatelj</th>--}}
                            {{--<th>Pacient</th>--}}
                            {{--<th>Zadolžena MS</th>--}}
                            {{--<th>Nadomestna MS</th>--}}
                        {{--</tr>--}}
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