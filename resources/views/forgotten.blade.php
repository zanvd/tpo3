<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
	<title>Pozabljeno geslo</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="main">
	<div class="heading">
		<div class="logo"><a href=""><img src="{{ URL::asset('cornerLogo2.png') }}" alt="logo"/></a></div>
	</div>
	<div class="mainJunior">
		<div class="content">
			<div class="myWife">
				<form class="article-comment" method="POST" action="/pozabljeno-geslo">
					{{ csrf_field() }}
					<div class="container  col-lg-12">
						<div class="title">
							Pozabljeno geslo
						</div>
						@if (count($errors))
							<div class="alert alert-danger">
								<ul>
									@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<div class="rowContainer">
							<p class="info alert-info">
								Na vaš e-mail naslov bomo poslali ponastavitveno povezavo, katera je aktivna eno uro.
							</p>
						</div>
						<div class="rowContainer">
							<label><b>E-mail:</b></label>
							<input type="email" placeholder="Vnesite e-mail..." name="email" required>
						</div>
						<div class="rowContainer">
							<button type="submit" class="btn btn-primary">Pošlji</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>



</body>
</html>
