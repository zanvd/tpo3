<div class="list-group">
	@if ($activeView == "dodajUporabnika")
	<a href="#" class="list-group-item main-color-bg"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ustvari profil</a>
	@else
	<a href="#" class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ustvari profil</a>
	@endif
	@if ($activeView == "spremeniGeslo")
	<a href="/spremeni-geslo" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@else
	<a href="/spremeni-geslo" class="list-group-item"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@endif
	@if ($activeView == "users")
	<a href="#" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Uporabniki</a>
	@else
	<a href="#" class="list-group-item"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Uporabniki</a>
	@endif
</div>