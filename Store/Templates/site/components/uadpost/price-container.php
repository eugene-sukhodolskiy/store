<?php
	/**
	 * @var UAdPost $uadpost
	 */
	$price = $uadpost -> get_price_particles();
	$single_price = $uadpost -> get_single_price_particles();
?>

<div class="component price-container" data-alt-price-flag="<?= $uadpost -> currency != "UAH" ? 1 : 0 ?>">
	<div class="price-wrap">
		<div class="original-price">
			<span class="price">
				<?= $price["banknotes"] ?><span class="coins">,<?= $price["coins"] ?></span>
			</span> 
			<span class="currency"><?= $uadpost -> get_formatted_currency() ?></span>
		</div>
		<? if($uadpost -> currency != "UAH"): ?>
			<div class="single-price">
				<span class="price">
					<?= $single_price["banknotes"] ?><span class="coins">,<?= $single_price["coins"] ?></span>
				</span> 
				<span class="currency"><?= $uadpost -> get_formatted_currency("UAH") ?></span>
			</div>
		<? endif ?>
		</div>

		<? if($uadpost -> currency != "UAH"): ?>
			<div class="swap-icon">
				<span class="mdi mdi-swap-horizontal"></span>
			</div>
		<? endif ?>
</div>