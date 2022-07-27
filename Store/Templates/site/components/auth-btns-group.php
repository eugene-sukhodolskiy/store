<div class="component auth-btns-group">
	<a href="<?= app() -> routes -> urlto("Auth@signin_page") ?>">Войти</a>
	<a 
		href="<?= app() -> routes -> urlto("Auth@signup_page") ?>" 
		class="std-btn btn-success"
	>Регистрация</a>
</div>