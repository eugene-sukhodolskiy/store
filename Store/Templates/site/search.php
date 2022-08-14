<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="filters-container"></div>
<div class="search-result">
	<? foreach ($uadposts as $uadpost): ?>
		<div class="search-item">
			<?= $this -> join("site/components/uadpost/uadpost-card.php", [
				"uadpost" => $uadpost,
				"displaying_saler" => true
			]) ?>
			
			<?= $this -> join("site/components/user/compact-user-card", [
				"user" => $uadpost -> user()
			]) ?>
		</div>
	<? endforeach ?>
</div>
