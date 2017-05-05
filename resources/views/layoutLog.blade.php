
<!DOCTYPE html>
<html lang="sl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="{{ URL::asset('favicon.ico') }}">
    @yield('title')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
  </head>

  <body>

    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <a id = "logo" class="navbar-brand" href="/">
            <img alt="Brand" src="{{ URL::asset('siteBrand.png') }}">
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">PATRONAŽA</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            @if( ! empty($name) )
            <li><a href="#">{{$name}}</a></li>
            @endif
            <li><a href="/odjava">Odjava</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    @yield('header')

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            
            @yield('menu')

            <div class="well">
              @if( ! empty($role) )
              <h5><b>Vloga:</b> {{$role}}</h5>
              @endif
              @if( ! empty($lastLogin) )
              <h5><b>Zadnja prijava:</b> {{$lastLogin}}</h5>
              @endif
            </div>
          </div>


          <div class ="col-md-9">
            @yield('content')
          </div>
        </div>
      </div>
    </section>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ URL::asset('js/script.js') }}"></script>
  </body>
</html>
