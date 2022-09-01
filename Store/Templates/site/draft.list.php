<?= $this -> extends_from("\Store\Templates\Logic\UserArea:user.area") ?>

<div class="alert-container"></div>

<? if($total_uadposts): ?>
	<? foreach ($uadposts as $i => $uadpost): ?>
		<div class="uadpost-item">
			<?= $this -> join("site/components/uadpost/uadpost-card.php", [
				"uadpost" => $uadpost,
				"displaying_saler" => false
			]) ?>
			
			<div class="uadpost-control-panel-wrap">
				<div class="visual-binder"></div>
				<?= $this -> join("site/components/uadpost/uadpost-control-panel", [
					"uadpost" => $uadpost
				]) ?>
			</div>
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