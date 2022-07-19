<?php
	/**
	 * @var String $action Required argument
	 * @var String $title
	 * @var Array $addition_classes
	 */
?>

<div class="component signup-form <?= $addition_classes ?>">
	<div class="row">
		<div class="col col-7">
			<form action="<?= $action ?>" class="form">
				<? if(isset($title) and $title): ?>
					<h1 class="title"><?= $title ?></h1>
				<? endif ?>

				<input type="hidden" name="signup" data-for-submiting>

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
					<button class="std-btn btn-primary submit">Зарегистрироваться</button>
				</div>

				<div class="alert-container"></div>
			</form>
		</div>

		<div class="col col-5">
			<div class="welcome">
				
			</div>
		</div>
	</div>
</div>