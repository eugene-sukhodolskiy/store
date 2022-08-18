<div class="location" title="<?= $region ?>">
	<span class="mdi mdi-map-marker-outline"></span>
	<? if($city): ?>
		<span class="city"><?= $city ?></span>,
	<? endif ?>
	
	<? if($country): ?>
		<span class="country"><?= $country ?></span>
	<? endif ?>
</div>