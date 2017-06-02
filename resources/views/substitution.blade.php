@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrapValidator.js') }}"></script>
    <script src="{{ URL::asset('js/substitutionValidate.js') }}"></script>
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
                            <th>Konec odsotnosti</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if( ! empty($substitutions) )
                                @foreach($substitutions as $substitution)
                                    <tr>
                                        <td>#{{$loop->iteration}}</td>
                                        <td>{{$substitution->absent}}</td>
                                        <td>{{$substitution->subs}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $substitution->start_date)->format('d.m.Y')}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $substitution->end_date)->format('d.m.Y')}}</td>
                                        @if($substitution->canceled == 1)
                                            <td>Preklicano</td>
                                        @elseif($substitution->finished == 1)
                                            <td>Zaključeno</td>
                                        @else
                                            <td>
                                                <form class="article-comment" id="newSubstitutionForm" method="POST" action="/nadomeščanja/končaj">
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-basic" id="finishSub" name="finishSub" value="{{$substitution->substitution_id}}" type="submit">
                                                        Zaključi nadomeščanje
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary" id="newSub">Novo nadomeščanje</button>
                </div>
                <br/>
                <div class="hidden" id="createNew">
                    <form class="article-comment" id="newSubstitutionForm" method="POST" data-toggle="validator" action="/nadomeščanja" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Odsotna sestra</label>
                                    <select data-live-search="true" class="form-control selectpicker" name="absent" id="absent" title="Izberite..." required>
                                        @if( ! empty($sisters) )
                                            @foreach($sisters as $key => $value)
                                                <option value="{{ $key}}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nadomestna sestra</label>
                                    <select data-live-search="true" class="form-control selectpicker" name="present" id="present" title="Izberite..." required>
                                        @if( ! empty($sisters) )
                                            @foreach($sisters as $key => $value)
                                                <option value="{{ $key}}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Odsotna od</label>
                                    <input class="form-control date datepicker" type="text" name="dateFrom" id="dateFrom" placeholder="Vnesite datum...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Odsotna do</label>
                                    <input class="form-control date datepicker" type="text" name="dateTo" id="dateTo" placeholder="Vnesite datum...">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit">Shrani</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
