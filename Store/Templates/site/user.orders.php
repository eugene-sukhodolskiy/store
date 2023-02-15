<?= $this -> extends_from("\Store\Templates\Logic\UserArea:user.area") ?>

<div class="alert-container"></div>

<? if($total_orders): ?>
	<? foreach ($orders as $i => $order): ?>
		<div class="uadpost-item">
			<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card-micro.php", [
				"uadpost" => $order -> uadpost()
			]) ?>

			<div class="seller">
				<?= $this -> join("site/components/user/compact-user-card", [
					"user" => $order -> uadpost() -> user()
				]) ?>
			</div>
			
			<div class="uadpost-control-panel-wrap">
				<div class="visual-binder"></div>
				<?= $this -> join("site/components/uadpost/uadpost-control-panel", [
					"uadpost" => $order -> uadpost()
				]) ?>
			</div>
		</div>
	<? endforeach ?>

	<?= $this -> join("Store\Templates\Logic\Paginator:site/components/paginator", [
		"id" => "profile_orders",
		"per_page" => $per_page,
		"total" => $total_orders
	]) ?>
<? else: ?>
	<h3>Здесь ничего нету</h3>
<? endif ?>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		if(document.location.hash.indexOf("deactivate-success") != -1) {
			document.location.hash = "#";
			createAlertComponent(
				"success", 
				"Ваше объявлние успешно деактивировано", 
				true, 
				true
			).showIn(document.querySelector(".alert-container"));
		}

		if(document.location.hash.indexOf("activate-success") != -1) {
			document.location.hash = "#";
			createAlertComponent(
				"success", 
				"Ваше объявлние успешно активировано", 
				true, 
				true
			).showIn(document.querySelector(".alert-container"));
		}
	});
</script>