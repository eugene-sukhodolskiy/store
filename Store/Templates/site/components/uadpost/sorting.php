<?php
	/**
	 * @var String $value
	 * @var String $input_name
	 * @var Array $variants
	 */
?>
<div class="component sorting">
	<div class="displaying-current-selected">
		<span class="mdi mdi-sort"></span>
		<span class="current-selected"><?= $variants[$value] ?? "Undefined" ?></span>
		<span class="mdi mdi-chevron-down"></span>
	</div>

	<input type="hidden" data-name="result-value" name="<?= $input_name ?? "undefined" ?>" value="<?= $value ?? "" ?>">

	<div class="select">
		<ul class="clickable-list">
			<? foreach($variants as $value => $name): ?>
				<li class="list-item">
					<button data-select-sorting-by="<?= $value ?>"><?= $name ?></button>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>