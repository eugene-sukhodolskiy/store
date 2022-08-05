<nav class="component navigation-main">
	<ul class="nav-list">
		<li class="nav-list-item">
			<a href="/" class="nav-link">Главная</a>
		</li>
		<li class="nav-list-item">
			<a href="#" class="nav-link">Избранное</a>
		</li>
		<li class="nav-list-item">
			<a href="#" class="nav-link">Сообщения</a>
		</li>
		<li class="nav-list-item">
			<a 
				href="<?= app() -> routes -> urlto("UAdPostController@create_page") ?>" 
				class="std-btn btn-primary create-uadpost"
			>
				<span class="mdi mdi-plus"></span>
				Новое объявление
			</a>
		</li>
	</ul>
</nav>