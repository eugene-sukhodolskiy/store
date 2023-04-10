<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="markup">
	<div class="profile-info">
		<?= $this -> join("site/components/user/user-card.php", [
			"user" => $user
		]) ?>
	</div>
	<div class="profile-uadposts">
		<? if($total_uadposts): ?>
			<? foreach ($uadposts as $uadpost): ?>
				<div class="profile-uadpost-item">
					<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card.php", [
						"uadpost" => $uadpost,
						"displaying_saler" => false
					]) ?>
				</div>
			<? endforeach ?>
		<? else: ?>
			<h3>Объявлений ещё нет</h3>
		<? endif ?>

		<?= $this -> join("\Store\Templates\Logic\Paginator:site/components/paginator", [
			"id" => "search-result-paginator",
			"per_page" => $per_page,
			"total" => $total_uadposts
		]) ?>
	</div>
</div>