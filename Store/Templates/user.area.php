<?= $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h2 class="heading"><?= $page_title ?></h2>

<div class="user-area">
	<div class="user-area-navigation">

		<ul class="clickable-list">
			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto(
						"UAdPostController@ready_uadposts_cur_user_page", 
						["state" => "published"]
					) ?>"
					<? if(app() -> utils -> link_is_active(
							"UAdPostController@ready_uadposts_cur_user_page", 
							["state" => "published"]
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-check-bold"></span>	
					Активные объявления
					<div class="counter"><?= $total_published_uadposts ?></div>
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto(
						"UAdPostController@ready_uadposts_cur_user_page", 
						["state" => "unpublished"]
					) ?>"
					<? if(app() -> utils -> link_is_active(
							"UAdPostController@ready_uadposts_cur_user_page", 
							["state" => "unpublished"]
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-close-thick"></span>	
					Неактивные объявления
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto(
						"UAdPostController@ready_uadposts_cur_user_page", 
						["state" => "draft"]
					) ?>"
					<? if(app() -> utils -> link_is_active(
							"UAdPostController@ready_uadposts_cur_user_page", 
							["state" => "draft"]
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-file-document-edit-outline"></span>	
					Черновики
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto(
						"OrderController@orders_cur_user_page", 
						["utype" => "customer"]
					) ?>"
					<? if(app() -> utils -> link_is_active(
							"OrderController@orders_cur_user_page", 
							["utype" => "customer"]
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-package-variant-closed"></span>	
					Мои покупки
				</a>
			</li>

			<li class="list-item">
				<a 
					href="<?= app() -> routes -> urlto(
						"OrderController@orders_cur_user_page", 
						["utype" => "seller"]
					) ?>"
					<? if(app() -> utils -> link_is_active(
							"OrderController@orders_cur_user_page", 
							["utype" => "seller"]
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-truck-fast-outline"></span>	
					Мои продажи
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
				<a 
					href="<?= app() -> routes -> urlto(
						"FavouritesController@favourites_page"
					) ?>"
					<? if(app() -> utils -> link_is_active(
						"FavouritesController@favourites_page"
					)): ?>
						class="active"
					<? endif ?>
				>
					<span class="mdi mdi-star-outline"></span>	
					Избранные
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