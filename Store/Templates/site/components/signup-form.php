<?php
	/**
	 * @var String $action Required argument
	 * @var String $title
	 * @var Array $addition_classes
	 */
?>

<div class="component signup-form <?= $addition_classes ?>">
	<? if(isset($title) and $title): ?>
		<h1 class="title"><?= $title ?></h1>
	<? endif ?>

	<form action="<?= $action ?>">
		<input type="hidden" name="signup" data-for-submiting>

		<div class="form-group">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" data-for-submiting placeholder="E-mail">
		</div>

		<div class="form-group">
			<label for="password">Пароль</label>
			<input type="password" name="password" id="password" data-for-submiting placeholder="Пароль">
		</div>

		<div class="form-group">
			<label for="password_again">Повторите пароль</label>
			<input type="password" name="password_again" id="password_again" data-for-submiting placeholder="Повторите пароль">
		</div>

		<div class="form-group">
			<button class="submit">Зарегистрироваться</button>
		</div>
	</form>
</div>