<div class="component userbar">
	<div class="userpic-wrapper">
		<a 
			href="<?= app() -> routes -> urlto("ProfileController@profile_page", ["user_alias" => $user -> alias]) ?>"
			class="userpic-link"
		>
			<img 
				src="<?= $user -> profile() -> userpic_url("xs") ?>" 
				alt="<?= $user -> profile() -> first_name ?> <?= $user -> profile() -> second_name ?>" 
				class="userpic"
			>
		</a>
	</div>
	<div class="user-name">
		<a 
			href="<?= app() -> routes -> urlto("ProfileController@profile_page", ["user_alias" => $user -> alias]) ?>" 
			class="user-name-link"
		>
			<? if($user -> profile() -> first_name): ?>
				<?= $user -> profile() -> first_name ?>
				<?= $user -> profile() -> second_name ?>
			<? else: ?>
				<?= strstr($user -> email, "@", true) ?>
			<? endif ?>
		</a>
	<span class="mdi mdi-chevron-down"></span>
	</div>
	<div class="user-nav-wrapper">
		<?= $this -> join("site/components/user-nav") ?>
	</div>
</div>