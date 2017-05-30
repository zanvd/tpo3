<div class="list-group">
	@if ($activeView == "mojProfil")
	<a href="/profil" class="list-group-item main-color-bg"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@else
	<a href="/profil" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@endif
	@if ($activeView == "seznamDN")
	<a href="/delovni-nalog" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
	@else
	<a href="/delovni-nalog" class="list-group-item"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
	@endif
	@if ($activeView == "planObiskov")
	<a href="/nacrt-obiskov/ustvari" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Plan obiskov</a>
	@else
	<a href="/nacrt-obiskov/ustvari" class="list-group-item"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Plan obiskov</a>
	@endif
	@if ($activeView == "spremeniGeslo")
	<a href="/spremeni-geslo" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@else
	<a href="/spremeni-geslo" class="list-group-item"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@endif
</div>