<div class="component userbar">
	<div class="userpic-wrapper">
		<a href="#" class="userpic-link">
			<img src="/Store/Resources/img/placeholder-150x150.png" alt="" class="userpic">
		</a>
	</div>
	<div class="user-name">
		<a href="#" class="user-name-link">
			<?= $user -> profile() -> first_name ?>
			<?= $user -> profile() -> second_name ?>
		</a>
	<span class="mdi mdi-chevron-down"></span>
	</div>
	<div class="user-nav-wrapper">
		<?= $this -> join("site/components/user-nav") ?>
	</div>
</div>