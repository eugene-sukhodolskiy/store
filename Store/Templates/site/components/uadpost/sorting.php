<?php
	/**
	 * @var String $value
	 * @var String $input_name
	 * @var Array $variants
	 */
?>

<div class="component sorting">
	<?= $this -> join("site/components/select", [
		"component_id" => "sorting-type-selector",
		"prefix" => '<span class="mdi mdi-sort"></span>',
		"default_text" => "Undefined",
		"value" => $value,
		"input_name" => $input_name,
		"variants" => $variants,
		"tabindex" => 8
	]) ?>
</div>