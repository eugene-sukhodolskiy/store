<?php
	/**
	 * @var String $action Required argument
	 * @var String $title
	 * @var Array $addition_classes
	 */
?>

<div class="component signup-form auth-form <?= $addition_classes ?>">
	<form action="<?= $action ?>" class="form" data-form-alias="signup">
		<div class="form-head">
			<? if(isset($title) and $title): ?>
				<h1 class="title"><?= $title ?></h1>
			<? endif ?>
		</div>

		<div class="form-body">
			<div class="form-group">
				<label class="form-label" for="email">E-mail</label>
				<input 
					type="email" 
					name="email" 
					id="email" 
					class="std-input"
					data-for-submiting 
					placeholder="E-mail"
				>
			</div>

			<div class="form-group">
				<label class="form-label" for="password">Пароль</label>
				<input 
					type="password" 
					name="password" 
					id="password" 
					class="std-input"
					data-for-submiting 
					placeholder="Пароль"
				>
			</div>

			<div class="form-group">
				<label class="form-label" for="password_again">Повторите пароль</label>
				<input 
					type="password" 
					name="password_again" 
					id="password_again" 
					class="std-input"
					data-for-submiting 
					placeholder="Повторите пароль"
				>
			</div>

			<div class="form-group">
				<input 
					type="checkbox" 
					class="std-input"
					name="terms_of_use"
					id="terms_of_use"
					data-for-submiting
					checked
				>
				<label for="terms_of_use" class="form-label">Я прочитал пользовательское 
					<a href="/page/term-of-use" target="_blank">соглашение</a>
				</label>
			</div>	

			<div class="form-group submit-btn-container">
				<div class="submit-btn-wrap">
					<button class="std-btn btn-primary submit">Зарегистрироваться</button>
				</div>
				<div class="accept-terms">
					Регистрируясь Вы подтверждаете свою ответственность за размещённое объявление.
				</div>
			</div>

			<div class="alert-container"></div>
		</div>

		<div class="form-footer">
			У меня уже есть аккаунт. <a href="<?= app() -> routes -> urlto('AuthController@signin_page') ?>">Войти</a>
		</div>
	</form>
	
	<div class="form-decoration"></div>
</div>