<?= $this -> extends_from("\Store\Templates\Logic\UserArea:user.area") ?>

<div class="alert-container"></div>

<?= $this -> join("site/components/order/order-state-filters.php", [
	"states" => array_combine($excluding_states, array_fill(0, count($excluding_states), "disable"))
]) ?>

<? if($total_orders): ?>
	<? foreach ($orders as $i => $order): ?>
		<div class="order-item">
			<?= $this -> join("\Store\Templates\Logic\OrderCard:site/components/order/order-card.php", [
				"utype" => $utype,
				"order" => $order
			]) ?>
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