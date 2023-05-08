<?php
	/**
	 * @var \Store\Entities\UAdPost $uadpost
	 */
?>

<div class="component uadpost-statistics">
	<div class="stat-item">
		<div class="stat-name">Просмотров:</div>
		<div class="stat-val"><?= $uadpost -> statistics() -> views ?></div>
	</div>
	<div class="stat-item">
		<div class="stat-name">В избранных у:</div>
		<div class="stat-val"><?= $uadpost -> statistics() -> in_favorites ?></div>
	</div>
	<div class="stat-item">
		<div class="stat-name">Просмотров тел. номера:</div>
		<div class="stat-val"><?= $uadpost -> statistics() -> phone_views ?></div>
	</div>
	<div class="stat-item">
		<div class="stat-name">Продано:</div>
		<div class="stat-val"><?= $uadpost -> statistics() -> sales ?></div>
	</div>
</div>