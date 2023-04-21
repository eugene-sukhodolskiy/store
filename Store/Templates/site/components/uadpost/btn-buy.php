<?
	/**
	 * @var UAdPost $uadpost
	 */
?>
<div class="component btn-buy">
	<button class="std-btn btn-success btn-buy" data-uadpost-alias="<?= $uadpost -> alias ?>">
		<span class="mdi mdi-cart-outline"></span>
		Купить
	</button>
	<?= $this -> join("site/components/uadpost/price-container", [
		"uadpost" => $uadpost
	]) ?>
</div>