<?php
	/**
	 * @var String $state ["active" or ""]
	 */
?>

<button 
	class="component std-btn btn-favorite <?= $state ?>"
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>