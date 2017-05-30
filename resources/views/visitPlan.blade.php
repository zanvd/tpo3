@extends('layoutLog')

@section('script')
    <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-datepicker.sl.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('js/workorderFilter.js') }}"></script>
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
    <!--
    @if( $status = Session::get('status'))
        <div class="alert alert-success" role="alert">{{ $status }}</div>
    @endif
    @if (count($errors))
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif-->
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
                                <th>Vrsta obiska</th>
                                <th>Delovni nalog</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
    </form>
    <div class="row">
    <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Seznam obiskov </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" id="datatable2">
                    <thead>
                        <tr>
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
                        <tr>
                                <td>
                                    <a href='#'>1 Odpri delovni nalog</a>
                                </td>
                                <td>16.2.2017</td>
                                <td>Obisk nosečnice</td>
                                <td>Marjana Kovač</td>
                                <td>
                                    Jana Pacient
                                    Franc Novorojencek
                                </td>
                                <td>Dr. House</td>
                                <td>
                                    Tina Nadomestna
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href='#'>2 Odpri delovni nalog</a>
                                </td>
                                <td>12.4.2017</td>
                                <td>Odvzem krvi</td>
                                <td>Tadej Kovač</td>
                                <td>
                                    Darko Pacient
                                </td>
                                <td>Dr. Dre</td>
                                <td>
                                    Maja Nadomestna
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href='#'>3 Odpri delovni nalog</a>
                                </td>
                                <td>20.3.2017</td>
                                <td>Navaden obisk</td>
                                <td>Lana Zidarič</td>
                                <td>
                                    Klara Pacient
                                </td>
                                <td>Dr. Ščinkavec</td>
                                <td>
                                    Nataša Nadomestna
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href='#'>4 Odpri delovni nalog</a>
                                </td>
                                <td>12.2.2017</td>
                                <td>Obisk nosečnice</td>
                                <td>Marjana Kovač</td>
                                <td>
                                    Katarina Pacient
                                    Maj Novorojencek
                                </td>
                                <td>Dr. House</td>
                                <td>
                                    Jana Nadomestna
                                </td>
                            </tr>
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection