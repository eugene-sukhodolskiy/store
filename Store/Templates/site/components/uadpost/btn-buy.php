<?
	/**
	 * @var String $uadpost_alias
	 * @var Float $price
	 * @var String $currency
	 */
?>
<div class="component btn-buy">
	<button class="std-btn btn-success btn-buy" data-uadpost-alias="<?= $uadpost_alias ?>">
		<span class="mdi mdi-cart-outline"></span>
		Купить
	</button>
	<div class="price">
		<?= $price ?>
		<span class="currency"><?= $currency ?></span>
	</div>
</div>