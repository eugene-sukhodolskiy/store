<?php
	/**
	 * @var String $unit
	 * @var Int $min
	 * @var Int $max
	 * @var Int $start_val
	 * @var String $form_name
	 */
?>

<div 
	class="component slider" 
	data-min-val="<?= isset($min) ? $min : 0  ?>" 
	data-max-val="<?= isset($max) ? $max : 0 ?>" 
	data-val="<?= isset($start_val) ? $start_val : 0 ?>"
>
	<input 
		type="hidden" 
		class="form-value-container"
		name="<?= $form_name ?>" 
		value="<?= isset($start_val) ? $start_val : 0 ?>"
	>

	<div class="struct">
		<div class="track">
			<div class="bar"></div>
			<div class="manipulator">
				<div class="visualization"></div>
			</div>
		</div>
		<div class="current-slider-val-container">
			<span class="current-slider-val"><?= isset($start_val) ? $start_val : 0 ?></span>
			<span class="current-slider-val-unit-name"><?= $unit ?></span>
		</div>
	</div>
</div>

<script src="/Store/Resources/js/Slider.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", e => {
		new Slider(document.querySelector(".component.slider"))
	});		
</script>