<?php
	/**
	 * @var String $state ["active" or ""]
	 * @var Int $uadpost_id
	 */
?>

<button 
	class="component std-btn btn-favorite <?= $state ?>"
	data-uadpost-id="<?= $uadpost_id ?>"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>