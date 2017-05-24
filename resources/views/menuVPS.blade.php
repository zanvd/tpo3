<div class="list-group">
	@if ($activeView == "mojProfil")
	<a href="/profil" class="list-group-item main-color-bg"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@else
	<a href="/profil" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Moj profil </a>
	@endif
	@if ($activeView == "novDN")
	<a href="/delovni-nalog/ustvari" class="list-group-item main-color-bg"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nov delovni nalog</a>
	@else
	<a href="/delovni-nalog/ustvari" class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nov delovni nalog</a>
	@endif
	@if ($activeView == "seznamDN")
	<a href="/delovni-nalog" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
	@else
	<a href="/delovni-nalog" class="list-group-item"> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Seznam delovnih nalogov</a>
	@endif
	@if ($activeView == "spremeniGeslo")
	<a href="/spremeni-geslo" class="list-group-item main-color-bg"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@else
	<a href="/spremeni-geslo" class="list-group-item"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Sprememba gesla</a>
	@endif
</div>