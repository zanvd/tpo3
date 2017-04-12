<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
        <title>Registracija</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/register.css') }}">
        <!-- Styles -->
        
    </head>
    <body>
        <div class="main">
        <div class="heading">
          <div class="logo"><a href=""><img src="{{ URL::asset('cornerLogo2.png') }}" alt="logo"/></a></div>
        </div>
        <div class="mainJunior">
        <div class="content">
            <form class="article-comment" method="POST" action="/login">
            <div class="container">
                <div class="title">
                Registracija uporabnika
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
                  <label><b></b></label>
                  <input type="password" placeholder="Ponovno vnesite geslo..." name="password" pattern=".{5,20}[a-zA-Z0-9]" id="geslo" required >
                </div>

                <div class="rowContainer">
                  <label><b>Ime:</b></label>
                  <input type="text" placeholder="Vnesite ime..." name="name" required>
                </div>
                <div class="rowContainer">
                  <label><b>Priimek:</b></label>
                  <input type="text" placeholder="Vnesite piriimek..." name="surname" required>
                </div>
                <div class="rowContainer">
                  <label><b>Spol:</b></label><br>
                  <input type="radio" name="spol" value="moski" checked> <label>Moški </label>
                  <input type="radio" name="spol" value="zenska"> <label>Ženska</label>
                </div>
                <div class="rowContainer2">
                  <label><b>Datum rojstva:</b></label>
                  <input type="date" placeholder="Vnesite datum oblike: dan.mesec.leto" name="birthDate" inputmode="numeric" required>
                </div>
                <div class="rowContainer">
                  <label><b>Telefon:</b></label>
                  <input type="text" placeholder="Vnesite telefonsko številko..." name="phoneNumber" pattern="[0-9]{8,9}" required>
                </div>
                <div class="rowContainer">
                  <label><b>Naslov:</b></label>
                  <input type="text" placeholder="Vnesite naslov..." name="addres" required>
                </div>
                <div class="rowContainer2">
                  <label><b>Šira okoliša:</b></label>
                  <input type="text" placeholder="Vnesite šifro okoliša..." name="areaNumber" required>
                </div>
                <div class="rowContainer2">
                  <label><b>ZZZS številka:</b></label>
                  <input type="text" placeholder="Vnesite ZZZS številko..." name="zzzs" pattern="[0-9]{9}" required>
                </div>
                <div class="titleRow">
                  Kontaktna oseba (neobvezno)
                </div>
                <div class="rowContainer">
                  <label><b>Ime:</b></label>
                  <input type="text" placeholder="Vnesite ime..." name="contactName" >
                </div>
                <div class="rowContainer">
                  <label><b>Priimek:</b></label>
                  <input type="text" placeholder="Vnesite piriimek..." name="contactSurname" >
                </div>
                <div class="rowContainer">
                  <label><b>Naslov:</b></label>
                  <input type="text" placeholder="Vnesite naslov..." name="contactAddress" >
                </div>
                <div class="rowContainer">
                  <label><b>Telefon:</b></label>
                  <input type="text" placeholder="Vnesite telefonsko številko..." name="contactPhoneNumber" pattern="[0-9]{8,9}" >
                </div>
                <div class="rowContainer2">
                  <label><b>Sorodstveno razmerje:</b></label>
                  <select name="fam">
                      <option value="1">STARŠ</option>
                      <option value="2">PARTNER</option>
                      <option value="3">OTROK</option>
                  </select>
                </div>
                <div class="rowContainer">
                  <button type="submit">Registracija</button>
                </div>
              
            </div>
            </form>
            
        </div>
        </div>
        </div>


        
    </body>
</html>
