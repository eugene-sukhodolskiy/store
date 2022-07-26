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
			<?= $this -> join("site/components/userbar") ?>
		</div>
	</div>
</div>