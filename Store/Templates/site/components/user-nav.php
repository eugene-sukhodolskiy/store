<nav class="component user-nav">
	<ul class="user-nav-list">
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Профиль</a>
		</li>
		<li class="user-nav-item">
			<a 
				href="<?= app() -> routes -> urlto(
					"UAdPostController@ready_uadposts_cur_user", 
					["state" => "published"]
				) ?>" 
				class="user-nav-link"
			>Мои объявления</a>
		</li>
		<li class="user-nav-item">
			<a 
				href="<?= app() -> routes -> urlto("ProfileSettingsController@profile_settings_page") ?>" 
				class="user-nav-link"
			>Настройки профиля</a>
		</li>
		<li class="user-nav-item">
			<a 
				href="<?= app() -> routes -> urlto("AuthController@signout_page", [ 
					"redirect_to" => $_SERVER["REQUEST_URI"] 
				]) ?>" 
				class="user-nav-link"
			>Выйти</a>
		</li>
	</ul>
</nav>