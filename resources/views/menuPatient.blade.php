<div class="list-group">
	@if ($activeView == "mojProfil")
	<a href="/profil" class="list-group-item main-color-bg"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@else
	<a href="/profil" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@endif

	@if ($activeView == "spremeniGeslo")
	<a href="/spremeni-geslo" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@else
	<a href="/spremeni-geslo" class="list-group-item"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@endif

	@if ($activeView == "dodajPacienta")
	<a href="/oskrbovani-pacient" class="list-group-item main-color-bg""> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj oskrbovanega pacienta</a>
	@else
	<a href="/oskrbovani-pacient" class="list-group-item "> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj oskrbovanega pacienta</a>
	@endif
</div>