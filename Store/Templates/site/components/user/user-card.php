<?php
	/**
	 * @var \Store\Entitties\User $user
	 */
?>
<div class="component user-card">
	<div class="profile">
		<div class="userpic">
			<a 
				href="<?= app() -> routes -> urlto("ProfileController@profile_page", ["user_alias" => $user -> alias]) ?>" 
				class="no-decoration"
			>
				<img 
					src="<?= $user -> profile() -> userpic_url("sm") ?>" 
					alt="<?= $user -> profile() -> first_name ?> <?= $user -> profile() -> second_name ?>"
				>
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="<?= app() -> routes -> urlto("ProfileController@profile_page", ["user_alias" => $user -> alias]) ?>">
					<? if($user -> profile() -> first_name): ?>
						<?= $user -> profile() -> first_name ?> 
						<?= $user -> profile() -> second_name ?>
					<? else: ?>
						<?= strstr($user -> email, "@", true) ?>
					<? endif ?>
				</a>
			</div>

			<div class="no-matter-text statistics">
				<?= $user -> statistics() -> total_saled ?> продано / 
				<?= $user -> statistics() -> total_published_uadposts ?> в продаже
			</div>

			<? $last_activity = $user -> last_session() ? $user -> last_session() -> get_last_activity() : false; ?>
			<? if($last_activity !== false): ?>
				<div class="last-activity">
					<? if($last_activity < 3): ?>
						<span class="label label-success">Сейчас на сайте</span>
					<? elseif($last_activity < 15): ?>
						<span class="label">Был недавно на сайте</span>
					<? elseif($last_activity < 60): ?>
						<span class="label">Заходил час назад</span>
					<? elseif(date("d.m.Y", strtotime($user -> last_session() -> last_using_at)) == date("d.m.Y")): ?>
						<span class="label">Был сегодня на сайте</span>
					<? else: ?>
						<span class="label">Был на сайте 
							<?= date("d.m.Y", strtotime($user -> last_session() -> last_using_at)) ?>
						</span>
					<? endif ?>
				</div>
			<? endif ?>
		</div>
	</div>

	<div class="btns-group">
		<div class="message-btn-wrap">
			<button class="std-btn btn-primary">
				<span class="mdi mdi-send"></span>
				Написать
			</button>
		</div>
		<div class="phone-number">
			<span class="mdi mdi-phone"></span>
			<a 
				href="#"
				data-show-phone-number="<?= $user -> profile() -> phone_number ?>"
			>
				Показать номер
			</a>
		</div>
	</div>
</div>
