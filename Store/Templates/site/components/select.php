<?php
	/**
	 * @var String $component_id
	 * @var String $prefix
	 * @var String $default_text
	 * @var String $value
	 * @var String $input_name
	 * @var Array $variants
	 * @var Int $tabindex
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
	<div 
		class="displaying-current-selected std-input" 
		tabindex="<?= $tabindex ?? 1 ?>"
	>
		<?= $prefix ?? "" ?>
		<span class="current-selected"><?= $text ?></span>
		<span class="mdi mdi-chevron-down select-icon"></span>
	</div>

	<input type="hidden" data-name="result-value" name="<?= $input_name ?? "undefined" ?>" value="<?= $value ?? "" ?>">

	<div class="selector">
		<?
			$items = [];
			foreach($variants as $variant) {
				$items[] = [
					"attrs" => [
						"data-option-value" => $variant["value"],
						"data-option-text" => $variant["text"]
					],
					"text" => "<button>{$variant["text"]}</button>"
				];
			}
		?>
		<?= $this -> join("site/components/advanced-clickable-list", [
			"items" => $items
		]) ?>
	</div>
</div>