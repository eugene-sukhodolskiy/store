<?php
	/**
	 * @var String $action Required argument
	 * @var String $title
	 * @var Array $addition_classes
	 */
?>

<div class="component signin-form <?= $addition_classes ?>">
	<form action="<?= $action ?>" class="form">
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

			<div class="form-group submit-btn-container">
				<div class="submit-btn-wrap">
					<button class="std-btn btn-primary submit">Войти</button>
				</div>
			</div>

			<div class="alert-container"></div>
		</div>

		<div class="form-footer">
			У меня нет аккаунта. <a href="<?= app() -> routes -> urlto('Auth@signup_page') ?>">Зарегистрироватся</a>
		</div>
	</form>
</div>