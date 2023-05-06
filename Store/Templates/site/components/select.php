<?php
	/**
	 * @var String $component_id
	 * @var String $prefix
	 * @var String $default_text
	 * @var String $value
	 * @var String $input_name
	 * @var Array $variants
	 */
	
	$default_text = $default_text ?? "Undefined";
	$text = $default_text;
	if($value) {
		foreach($variants as $item) {
			if($item["value"] == $value) {
				$text = $item["text"];
				break;
			}
		}
	}
?>

<div 
	class="component select" 
	id="<?= $component_id ?>"
	data-default-text="<?= $default_text ?>"
	data-default-value="<?= $value ?? "" ?>"
>
	<div class="displaying-current-selected std-input">
		<?= $prefix ?? "" ?>
		<span class="current-selected"><?= $text ?></span>
		<span class="mdi mdi-chevron-down select-icon"></span>
	</div>

	<input type="hidden" data-name="result-value" name="<?= $input_name ?? "undefined" ?>" value="<?= $value ?? "" ?>">

	<div class="selector">
		<ul class="clickable-list">
			<? foreach($variants as $i => $variant): ?>
				<li class="list-item">
					<button data-option-value="<?= $variant["value"] ?>"><?= $variant["text"] ?></button>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>