<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
        <title>Naov delovni nalog</title>

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
            <form class="article-comment" method="POST" action="/postOrder">
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
                <div class="container-blank">
                    <div class="pairRowContainer">
                      <div class="containerRow">
                        <div class="titleRow">
                          Napotnica
                        </div>
                        <div class="rowContainer2">
                          <label><b>Številka napotnice:</b></label>
                          <input type="text" placeholder="" name="insuranceNumber" required>
                        </div>
                        <div class="rowContainer2">
                          <label><b>Številka zdravnika:</b></label>
                          <input type="text" placeholder="" name="insuranceNumber" required>
                        </div>
                      </div>
                      <div class="containerRow">
                        <div class="titleRow">
                          Veljavnost naloga
                        </div>
                        <div class="rowContainer">
                          <input type="radio" name="valid" value="moski" onclick="enableField()" checked> <label>ENKRATNO </label>
                          <input type="radio" name="valid" value="zenska" onclick="disableField()"> <label>OBDOBJE</label>
                        </div>
                        <div class="rowContainer2">
                          <label><b>Mesecev:</b></label>
                          <input id="optionalField"type="text" placeholder="" name="validTime" required disabled="disabled">
                        </div>
                      </div>
                      <div class="containerRow">
                        <div class="titleRow">
                          Vrsta storitve
                        </div>
                        <div class="rowContainer">
                          <select name="serviceType">
                            <option value="1">DELOVNA TERAPIJA</option>
                            <option value="2">NEGA NA DOMU</option>
                            <option value="3">STORITVE PSIHOLOGA, LOGOPEDA, SPEC. PEDAGOGA</option>
                            <option value="4">RENTGENTSKO SLIKANJE</option>
                            <option value="5">LABORATORIJSKE IN DRUGE STORITVE</option>
                          </select>
                        </div>
                      </div>
                      <div class="containerRow">
                        <div class="titleRow">
                          Razlog obravnave
                        </div>
                        <div class="rowContainer">
                          <select name="reason">
                            <option value="1">BOLEZEN</option>
                            <option value="2">POŠKODBA IZVEN DELA</option>
                            <option value="3">POKLICNA BOLEZEN</option>
                            <option value="4">POŠKODBA PRI DELU</option>
                            <option value="5">POŠKODBA IZVEN DELA PO TRETJI OSEBI</option>
                            <option value="4">RENTGENTSKO SLIKANJE</option>
                            <option value="5">TRANSPLANTACIJA</option>
                          </select>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="pairContainer">
                <div class="container">
                  <div class="titleRow">
                    Tuji zavarovanec
                  </div>
                  <div class="rowContainer2">
                    <label><b>Šifra države:</b></label>
                    <input type="text" placeholder="" name="countryCode" required>
                  </div>
                </div>
                <div class="container">
                  <div class="titleRow">
                    Napoten k izvajalcu
                  </div>
                  <div class="rowContainer2">
                    <label><b>Naziv :</b></label>
                    <input type="text" placeholder="" name="contractorName" required>
                  </div>
                  <div class="rowContainer">
                    <label><b>Naslov :</b></label>
                    <input type="text" placeholder="" name="contractorAddress" required>
                  </div>
                </div>
              </div>
              <div class="largeContainer">
                <div class="titleRow">
                  Podatki o bolezni
                </div>
                <div class="rowContainer">
                  <textarea rows="4" cols="200" name="sicknessDescription"></textarea>
                  
                </div>
              </div>
              <div class="largeContainer">
                <div class="titleRow">
                  Naročene storitve
                </div>
                <div class="tabContainer">
                  <div class="smallCol1">
                  Zap. št.
                  </div>
                  <div class="bigCol">
                  Opis
                  </div>
                  <div class="smallCol2">
                  Število
                  </div>
                </div>
                <div id="serviceContainer">

                </div>
                <!-- test
                <div class="tabContainer">
                  <div class="smallCol1-content">
                  4
                  </div>
                  <div class="bigCol-content">
                  Nek opis
                  </div>
                  <div class="smallCol2-content">
                  2
                  </div>
                </div>-->
                <div class="tabContainer">
                  <div class="smallCol1-content">
                    <input id ="orderNumber" type="text" placeholder="" name="orderNumber" >
                  </div>
                  <div class="bigCol-content">
                    <input id="orderDesc" type="text" placeholder="" name="orderDesc" >
                  </div>
                  <div class="smallCol2-content">
                    <input id="orderQuantity" type="text" placeholder="" name="orderQuantity" >
                  </div>
                </div>
                <div class="tabContainer">
                  <button type="button" onclick="addService()">Dodaj</button>
                </div>
              </div>
              <div class="largeContainer">
                <div class="tabContainer">
                  <button type="submit">Oddaj delovni nalog</button>
                </div>
              </div>
            </form>
            
          </div>
        </div>
        </div>


        <script src="{{ URL::asset('js/work.js') }}"></script>
    </body>
</html>
