<?php
	/**
	 * @var UAdPost $uadpost
	 */
?>

<div class="component price-container">
	<? $price = $uadpost -> get_price_particles() ?>
	<span class="price">
		<?= $price["banknotes"] ?><span class="coins">,<?= $price["coins"] ?></span>
	</span> 
	<span class="currency"><?= $uadpost -> get_formatted_currency() ?></span>
</div>