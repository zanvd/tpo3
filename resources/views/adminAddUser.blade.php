@extends('layoutLog')

@section('title')
<title>Ustvari profil</title>
@endsection

@section('header')
<header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ustvari profil </h1>
          </div>
          <div class="col-md-2">
          </div>
        </div>
      </div>
    </header>
@endsection

@section('menu')
            <div class="list-group">
              <a href="#" class="list-group-item active main-color-bg">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ustvari profil
              </a>
              <a href="#" class="list-group-item"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Uporabniki</a>
            </div>
@endsection

@section('content')
		<div class="panel panel-default">
              {{ csrf_field() }}
              @if (count($errors))
                      @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                      @endforeach
              @endif
              @if( ! empty($status) )
                <div class="alert alert-success" role="alert">{{ $status }}</div>
              @endif
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Nov uporabnik</h3>
              </div>
              <div class="panel-body">
                <form class="article-comment" method="POST" action="/registracija/zaposleni">
                <div class="form-group">
                    <label for="function">Funkcija: </label>
                    <div class="form-control flex-parent">
                      <label class="radio-inline flex-child" onclick="disableField()"><input type="radio" name="function">Zdravnik</label>
                      <label class="radio-inline flex-child" onclick="enableField()"><input type="radio" name="function">Vodja PS</label>
                      <label class="radio-inline flex-child" onclick="enableField()"><input type="radio" name="function">Patronažna sestra</label>
                      <label class="radio-inline flex-child" onclick="enableField()"><input type="radio" name="function" checked>Uslužbenec ZD</label>
                    </div>
                </div>
                <div class="form-group">
                  <label>Email: </label>
                  <input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" required>
                </div>
                <div class="form-group">
                  <label>Geslo</label>
                    <input class="form-control" type="password" placeholder="Vnestie geslo..." name="password" pattern=".{5,20}[a-zA-Z0-9]" required>
                </div>
                <div class="form-group">
                  <label>Ponovite geslo</label>
                    <input class="form-control" type="password" placeholder="Ponovno vnesite geslo..." name="password_confirmation" pattern=".{5,20}[a-zA-Z0-9]" required>
                </div>
                <div class="form-group">
                  <label>Ime</label>
                    <input class="form-control" type="text" placeholder="Vnesite ime..." name="name" required>
                </div>
                <div class="form-group">
                  <label>Priimek</label>
                    <input class="form-control" type="text" placeholder="Vnesite ime..." name="surname" required>
                </div>
                <div class="form-group">
                  <label>Telefon</label>
                    <input class="form-control" type="text" placeholder="Vnesite vašo telefonsko številko..." name="phoneNumber" pattern="[0-9]{8,9}" required>
                </div>
                <div class="form-group">
                  <label>Naslov</label>
                    <input class="form-control" type="text" placeholder="Vnesite naslov..." name="address" required>
                </div>
                <div class="form-group">
                  <label>Poštna številka</label>
                    <select  data-live-search="true" data-live-search-style="startsWith" class="form-control selectpicker" name="postNumber" title="Izberite..." required>
                      @if( ! empty($posts) )
                              @foreach($posts as $key => $value)
                                <option value="{{ $key}}">{{ $value }}</option>
                              @endforeach
                      @endif 
                    </select>

                </div>
                <div class="form-group">
                  <label>Šifra izvajalca</label>
                    <select  data-live-search="true" data-live-search-style="startsWith" class="form-control selectpicker" name="institution" title="Izberite..." required>
                      @if( ! empty($institutions) )
                              @foreach($institutions as $key => $value)
                                <option value="{{ $key}}">{{ $value }}</option>
                              @endforeach
                      @endif  
                    </select>
                </div>
                <div class="form-group">
                  <label>Šifra okoliša</label>
                    <select id="region" data-live-search="true" data-live-search-style="startsWith" class="form-control selectpicker" name="region" title="Izberite..." required>
                      @if( ! empty($regions) )
                              @foreach($regions as $key => $value)
                                <option value="{{ $key}}">{{ $value }}</option>
                              @endforeach
                        @endif  
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Ustvari</button>
                </form>
              </div>
            </div>
@endsection