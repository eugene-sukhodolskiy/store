<?= $this -> extends_from("\Store\Templates\Logic\UserArea:user.area") ?>

<div class="alert-container"></div>

<? if($total_uadposts): ?>
	<? foreach ($uadposts as $i => $uadpost): ?>
		<div class="uadpost-item">
			<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card.php", [
				"uadpost" => $uadpost,
				"displaying_saler" => true
			]) ?>
		</div>
	<? endforeach ?>

	<?= $this -> join("Store\Templates\Logic\Paginator:site/components/paginator", [
		"id" => "profile_uadposts",
		"per_page" => $per_page,
		"total" => $total_uadposts
	]) ?>
<? else: ?>
	<h3>Здесь ничего нету</h3>
<? endif ?>