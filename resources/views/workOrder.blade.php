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
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/work.css') }}">
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
              <div class="titleContainer title">
                  Delovni nalog
              </div>
              <div class="pairContainer">
                <div class="container">
                  <div class="titleRow">
                    Izvajalec
                  </div>
                  <div class="rowContainer">
                    <label><b>Številka izvajalca:</b></label>
                    <input type="text" placeholder="" name="contractorNumber" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Številka zdr. dejavnosti:</b></label>
                    <input type="text" placeholder="" name="contractorNumber" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Naziv:</b></label>
                    <input type="text" placeholder="" name="contractorNumber" required>
                  </div>
                </div>
                <div class="container">
                  <div class="titleRow">
                    Zdravnik
                  </div>
                  <div class="rowContainer">
                    <label><b>Številka zdravnika:</b></label>
                    <input type="text" placeholder="" name="contractorNumber" required>
                  </div>
                  <div class="rowContainer">
                    <input type="radio" name="spcialization" value="moski" checked> <label>OSEBNI </label>
                    <input type="radio" name="spcialization" value="zenska"> <label>NAPOTNI</label>
                  </div>
                  <div class="rowContainer">
                    <input type="radio" name="spcialization" value="moski" checked> <label>NPM </label>
                    <input type="radio" name="spcialization" value="zenska"> <label>NADOMESTNI</label>
                  </div>
                </div>
              </div>
              <div class="pairContainer">
                <div class="container">
                    <div class="titleRow">
                      Zavarovana oseba
                    </div>
                    <div class="rowContainer">
                      <label><b>Številka zavarovane osebe:</b></label>
                      <input type="text" placeholder="" name="insuranceNumber" required>
                    </div>
                    <div class="rowContainer2">
                    <label><b>Datum rojstva:</b></label>
                    <input type="date" placeholder="Vnesite datum oblike: dan.mesec.leto" name="birthDate" inputmode="numeric" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Ime:</b></label>
                    <input type="text" placeholder="" name="name" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Priimek:</b></label>
                    <input type="text" placeholder="" name="surname" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Naslov:</b></label>
                    <input type="text" placeholder="" name="addres" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Kraj:</b></label>
                    <input type="text" placeholder="" name="city" required>
                  </div>
                  <div class="rowContainer2">
                    <label><b>Poštna številka:</b></label>
                    <input type="text" placeholder="" name="postcode" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Telefon:</b></label>
                    <input type="text" placeholder="" name="phoneNumber" pattern="[0-9]{8,9}">
                  </div>
                  <div class="rowContainer">
                    <label><b>E-mail:</b></label>
                    <input type="email" placeholder="" name="email">
                  </div>
                </div>
                <div class="container">
                </div>
              </div>
            </form>
            
        </div>
        </div>
        </div>


        
    </body>
</html>
