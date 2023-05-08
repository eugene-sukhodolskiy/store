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
</div>