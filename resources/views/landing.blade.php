<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
        <title>Patronaža</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/landing.css') }}">
        <!-- Styles -->
        
    </head>
    <body>
        <div class="heading links">
          <div class="logo"><a href=""><img src="{{ URL::asset('cornerLogo2.png') }}" alt="logo"/></a></div>
          <a href="{{ url('/prijava') }}">Prijava</a>
          <a href="{{ url('/register') }}">Registracija</a>
        </div>
        <div class="content">
          <div class="vsebovalnikBesedila">
            <div class="title"> Dobrodošli </div>
            <div class="info"> Za uporabo aplikacije je potrebna registracija. Če že imate račun se prijavite. </div>
            <div clas="vsebovalnikGumbov">
              <form action="{{ url('/register') }}">
              <button type="submit">Registracija</button>
              </form>
              <form action="{{ url('/prijava') }}">
              <button type="submit">Prijava</button>
              </form>
            </div>
          </div>
        </div>


        
        
    </body>
</html>
