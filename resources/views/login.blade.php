@extends('layout')

@section('title')
<title>Prijava</title>
@endsection

@section('content')
<div class="container">
        <div class="row">
        {{ csrf_field() }}
          <div class="col-md-6">
            @if (count($errors))
                    @foreach($errors->all() as $error)
                      <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
            @endif    
            <div class="panel panel-default">
              <div class="panel-body">
               <form>
                  <div class="form-group">
                    <label for="formEmail">Email</label>
                    <input class="form-control" type="email" placeholder="Vnestie e-naslov..." name="email" id="formEmail" required>
                  </div>
                  <div class="form-group">
                    <label for="formPassword">Geslo</label>
                    <input class="form-control" type="password" placeholder="Vnestie geslo..." name="password" pattern=".{5,20}[a-zA-Z0-9]" id="formPassword" required>
                  </div>
                  <button class="btn btn-primary" type="submit">Prijava</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6">
          </div>
      </div>
@endsection
