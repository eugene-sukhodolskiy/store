<div class="component auth-btns-group">
	<a href="<?= app() -> routes -> urlto("AuthController@signin_page") ?>">Войти</a>
	<a 
		href="<?= app() -> routes -> urlto("AuthController@signup_page") ?>" 
		class="std-btn btn-success"
	>Регистрация</a>
</div>