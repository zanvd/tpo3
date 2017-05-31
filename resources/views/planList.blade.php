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


    <div class="row">
    <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
            <h3 class="panel-title"> TODO</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection