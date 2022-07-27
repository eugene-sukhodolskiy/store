<div class="component navbar">
	<div class="container navbar-container">
		<div class="logo-wrapper">
			<div class="logo">
				<a href="/" class="logo-link">Logo</a>
			</div>
		</div>

		<div class="search-bar-wrapper">
			<?= $this -> join("site/components/search-bar") ?>
		</div>

		<div class="navigation-main-wrapper">
			<?= $this -> join("site/components/navigation-main") ?>
		</div>

		<div class="userbar-wrapper">
			<? if($is_auth): ?>
				<?= $this -> join("site/components/userbar") ?>
			<? else: ?>
				<?= $this -> join("site/components/auth-btns-group") ?>
			<? endif ?>
		</div>

		<button class="btn-nav-on-mob-show">
			<span class="mdi mdi-menu state-inactive"></span>	
			<span class="mdi mdi-close state-active"></span>	
		</button>
	</div>
</div>