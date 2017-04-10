<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registracija</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
            }
            
            .centrirano {
              max-width:500px;
              min-width: 500px;
              margin-left:auto;
              margin-right:auto;
            }

            .navbar {
              display: block;
              margin-left: auto;
              margin-right: auto;
              padding-bottom: 18px;
              right: 10px;
              top: 18px;
              text-align: right;
              overflow: hidden;
            }


            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
                margin-bottom: 30px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            input[type=text], input[type=password], input[type=date], input[type=email] {
                width: 100%;
                padding: 5px 8px;
                margin: 8px;
                background-color: white;
                border-radius: 5px;
            }

            input[type=radio] ~label {
                margin-right: 20px;
            }

            input[type=radio] {
                margin-top: 10px;
                margin-bottom: 8px;
            }

            button {
              background-color: #3399ff;
              
              border-radius: 5px;
              border: none;
              color: white;
              padding: 5px 8px;
              margin: 8px;
              display: inline-block;
              font-size: 14px;
              cursor: pointer;
            }

              
        </style>
    </head>
    <body>
        <div class= "navbar links">
          <a href="{{ url('/login') }}">Login</a>
        </div>
        <div class="centrirano">
                <div class="title content">
                    Registracija
                </div>

                    <form class="article-comment" method="POST" action="/login">
                      <label><b>E-mail</b></label>
                      <input type="email" placeholder="Vnestie e-naslov..." name="email" required>
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
                      <input type="date" placeholder="Vnesite datum oblike: dan.mesec.leto" name="datumrojstva"
                      inputmode="numeric" required>
                      <label><b>Številka zdravstvene kartice</b></label>
                      <input type="text" placeholder="Vnesite številko kartice..." name="stevilkakartice" pattern="[0-9]{9}" required>
                      <label><b>Naslov</b></label>
                      <input type="text" placeholder="Vnesite naslov..." name="naslov" required>
                      <label><b>Šifra okoliša</b></label>
                      <input type="text" placeholder="Vnesite šifro okoliša..." name="sifraokolisa" required>
                      <label><b>Telefon</b></label>
                      <input type="text" placeholder="Vnesite vašo telefonsko številko..." name="naslov" pattern="[0-9]{7,8}"required>
                      <button type="submit">Prijava</button>
                    </form>

        </div>
    </body>
</html>
