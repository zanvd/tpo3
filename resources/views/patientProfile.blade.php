@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
@endsection


@section('header')
<header id="header">
    <div class="container">
    <div class="row">
      <div class="col-md-10">
      <h1><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Moj profil </h1>
      </div>
      <div class="col-md-2">
      </div>
    </div>
    </div>
  </header>
@endsection

@section('menu')
      <div class="list-group">
        <a href="/profile" class="list-group-item active main-color-bg">
         <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil
        </a>
        <a href="/spremeni-geslo" class="list-group-item "> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
        <a href="/oskrbovani-pacient" class="list-group-item"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj oskrbovanega pacienta</a>
      </div>
@endsection

@section('content')
  <div class="panel panel-default">
    <div class="panel-heading main-color-bg">
      <h3 class="panel-title">Oskrbovani pacienti</h3>
    </div>
    <div class="panel-body">
      @if (empty($patients))
      <p>Dodanega nimate nobenega oskrbovanega pacienta.</p>
      @else
      <table class="table">
        <thead>
          <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Spol</th>
            <th>Rojstni dan</th>
            <th>ZZZS</th>
          </tr>
        </thead>
        <tbody>
          @foreach($patients as $patient)
            <tr>
            @foreach($patient as $value)
              <td>{{ $value}}</td>
            @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
@endsection
