<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('favicon1.ico') }}">
	<title>Ponastavitev gesla</title>

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
				<form class="article-comment" method="POST" action="/ponastavi-geslo">
					{{ csrf_field() }}
					<div class="container  col-lg-12">
						<div class="title">
							Ponastavitev gesla
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
						<input type="text" class="hidden" name="token" value={{ $token }}>
						<div class="rowContainer">
							<label><b>E-mail:</b></label>
							<input type="email" placeholder="Vnesite e-mail..." name="email" required value={{ $email or '' }}>
						</div>
						<div class="rowContainer">
							<label><b>Novo geslo:</b></label>
							<input type="password" placeholder="Vnesite novo geslo..." name="password" pattern=".{6,64}" id="geslo" required >
						</div>
						<div class="rowContainer">
							<label><b>Potrditev gesla:</b></label>
							<input type="password" placeholder="Vnesite potrditev gesla..." name="password_confirmation" pattern=".{6,64}" id="geslo" required >
						</div>
						<div class="rowContainer">
							<button type="submit" class="btn btn-primary">Ponastavi</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>



</body>
</html>
