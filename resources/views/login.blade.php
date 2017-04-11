<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
        <title>Prijava</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
        <!-- Styles -->
        
    </head>
    <body>
        <div class="main">
        <div class="heading">
          <div class="logo"><a href=""><img src="{{ URL::asset('cornerLogo2.png') }}" alt="logo"/></a></div>
        </div>
        <div class="mainJunior">
        <div class="content">
            <div class="myWife">
                  <form class="article-comment" method="POST" action="/login">
                  <div class="container">
                      <div class="title">
                      Prijava
                      </div>
                      <div class="rowContainer">
                        <label><b>E-mail:</b></label>
                        <input type="email" placeholder="Vnestie e-naslov..." name="email" required>
                      </div>
                      <div class="rowContainer">
                        <label><b>Geslo:</b></label>
                        <input type="password" placeholder="Vnesite geslo..." name="password" pattern=".{5,20}[a-zA-Z0-9]" id="geslo" required >
                      </div>
                      <div class="rowContainer">
                        <button type="submit">Prijava</button>
                      </div>
                  </div>
                  </form>
            </div>
            
        </div>
        </div>
        </div>

        
        
    </body>
</html>
