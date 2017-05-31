@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>đ
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    <title>Nadomeščanja</title>
    <?php $activeView = 'nadomescanja' ?>
@endsection

@section('header')
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Nadomeščanja</h1>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </header>
@endsection

@section('menu')
    @include('menuVPS')
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
        <div class="panel panel-primary filterable">
            <div class="panel-heading main-color-bg">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title"> Nadomeščanja</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row col-md-12" style="margin-top: 10px;">
                    <table class="table table-hover" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Odsotna sestra</th>
                            <th>Nadomestna sestra</th>
                            <th>Odsotna od</th>
                            <th>Odsotna do</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if( ! empty($substitutions) )
                            @foreach($substitutions as $substitution)
                                <tr>
                                    <td>#{{$loop->iteration}}</td>
                                    <td id="absent">{{$substitution->absent}}</td>
                                    <td id="subs">{{$substitution->subs}}</td>
                                    <td id="startDate">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $substitution->start_date)->format('d.m.Y')}}</td>
                                    <td id="endDate">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $substitution->end_date)->format('d.m.Y')}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Novo nadomeščanje</button>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Odsotna sestra</label>
                            <select data-live-search="true" class="form-control selectpicker" name="absent" id="absent" title="Izberite..." >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nadomestna sestra</label>
                            <select data-live-search="true" class="form-control selectpicker" name="present" id="present" title="Izberite..." >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Odsotna od</label>
                            <input type="text" placeholder="Vnesite datum..." name="dateFrom" id="dateFrom" class="form-control date datepicker">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Odsotna do</label>
                            <input type="text" placeholder="Vnesite datum..." name="dateTo" id="dateTo" class="form-control date datepicker">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Shrani</button>
                </div>
            </div>
        </div>
    </div>
@endsection
