<nav class="component user-nav">
	<ul class="user-nav-list">
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Профиль</a>
		</li>
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Тест 1</a>
		</li>
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Двинное слово</a>
		</li>
		<li class="user-nav-item">
			<a 
				href="<?= app() -> routes -> urlto("Auth@signout_page", [ "redirect_to" => $_SERVER["REQUEST_URI"] ]) ?>" 
				class="user-nav-link"
			>Выйти</a>
		</li>
	</ul>
</nav>