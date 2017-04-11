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
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/register.css') }}">
        <!-- Styles -->
        
    </head>
    <body>
        <div class="heading">
          <div class="logo"><a href=""><img src="{{ URL::asset('cornerLogo2.png') }}" alt="logo"/></a></div>
        </div>
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
                  <input type="text" placeholder="Vnesite vašo telefonsko številko..." name="phoneNumber" pattern="[0-9]{7,8}"required>
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
                  <input type="text" placeholder="Vnesite ZZZS številko..." name="zzzs" required>
                </div>
                <div class="rowContainer">
                  <button type="submit">Registracija</button>
                </div>

                
                <!--

                  <select name="month">
                    <option value="1">Januar</option>
                    <option value="2">Februar</option>
                    <option value="3">Marec</option>
                    <option value="4">April</option>
                    <option value="5">Maj</option>
                    <option value="6">Junuj</option>
                    <option value="7">Julij</option>
                    <option value="8">Avgust</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>

                <label><b>Geslo</b></label>
                <input type="password" placeholder="Vnesite geslo..." name="geslo" pattern=".{5,20}[a-zA-Z0-9]" id="geslo" required >
                <label><b>Ponovi geslo</b></label>
                <input type="password" placeholder="Ponovite geslo..." name="pgeslo" pattern=".{5,20}[a-zA-Z0-9]" id="pgeslo" required>
                <label><b>Ime</b></label>
                <input type="text" placeholder="Vnesite ime..." name="ime" required>
                <label><b>Priimek</b></label>
                <input type="text" placeholder="Vnesite piriimek..." name="priimek" required>
                <label><b>Spol</b></label><br>
                <input type="radio" name="spol" value="moski" checked> <label>Moški </label>
                <input type="radio" name="spol" value="zenska"> <label>Ženska</label> <br>
                <label><b>Datum rojstva</b></label>
                <input type="date" placeholder="Vnesite datum oblike: dan.mesec.leto" name="datumrojstva" inputmode="numeric" required>
                <label><b>Številka zdravstvene kartice</b></label>
                <input type="text" placeholder="Vnesite številko zdravstvene kartice..." name="stevilkakartice" pattern="[0-9]{9}" required>
                <label><b>Naslov</b></label>
                <input type="text" placeholder="Vnesite naslov..." name="naslov" required>
                <label><b>Šifra okoliša</b></label>
                <input type="text" placeholder="Vnesite šifro okoliša..." name="sifraokolisa" required>
                <label><b>Telefon</b></label>
                <input type="text" placeholder="Vnesite vašo telefonsko številko..." name="naslov" pattern="[0-9]{7,8}"required>
                <button type="submit">Prijava</button>-->
              
            </div>
            </form>
            
        </div>


        
        
    </body>
</html>
