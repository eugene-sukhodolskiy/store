<div class="component compact-user-card">
	<div class="std-row">
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
				<a 
					href="<?= app() -> routes -> urlto("ProfileController@profile_page", ["user_alias" => $user -> alias]) ?>"
				><?= $user -> profile() -> first_name ?> <?= $user -> profile() -> second_name ?></a>
			</div>
			<div class="no-matter-text">
				<?= $user -> statistics() -> total_saled ?> продано / 
				<?= $user -> statistics() -> total_published_uadposts ?> в продаже
			</div>
		</div>
	</div>
</div>