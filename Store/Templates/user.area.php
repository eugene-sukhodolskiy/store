<?= $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h2><?= $page_title ?></h2>

<div class="user-area">
	<div class="user-area-navigation">

		<ul class="clickable-list">
			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto("UAdPostController@published_uadposts_cur_user") ?>"
					<? if(app() -> utils -> link_is_active("UAdPostController@published_uadposts_cur_user")): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-check-bold"></span>	
					Мои активные объявления
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto("UAdPostController@unpublished_uadposts_cur_user") ?>"
					<? if(app() -> utils -> link_is_active("UAdPostController@unpublished_uadposts_cur_user")): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-close-thick"></span>	
					Мои неактивные объявления
				</a>
			</li>

			<li class="list-item">
				<a href="#">
					<span class="mdi mdi-file-document-edit-outline"></span>	
					Мои черновики
				</a>
			</li>
		</ul>

		<ul class="clickable-list">
			<li class="list-item">
				<a href="#">
					<span class="mdi mdi-account"></span>	
					Моя страница
				</a>
			</li>

			<li class="list-item">
				<a href="#">
					<span class="mdi mdi-chart-bar"></span>	
					Статистика
				</a>
			</li>

			<li class="list-item">
				<a href="#">
					<span class="mdi mdi-lock-outline"></span>	
					Безопасность
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto("ProfileSettingsController@profile_settings_page") ?>"
					<? if(app() -> utils -> link_is_active("ProfileSettingsController@profile_settings_page")): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-cog"></span>
					Настройки профиля
				</a>
			</li>
		</ul>

	</div>
	<div class="user-area-page">
		<?= $this -> content() ?>
	</div>
</div>	