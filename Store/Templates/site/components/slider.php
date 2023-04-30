<?php
	/**
	 * @var String $unit
	 * @var Int $min
	 * @var Int $max
	 * @var Int $start_val
	 * @var Int $default_val
	 * @var String $form_name
	 */
	
	$default_val = isset($default_val) ? $default_val : 0;
	$start_val = isset($start_val) ? $start_val : $default_val;
?>

<div 
	class="component slider" 
	data-min-val="<?= isset($min) ? $min : 0  ?>" 
	data-max-val="<?= isset($max) ? $max : 0 ?>" 
	data-val="<?= $start_val ?>"
	data-default-val="<?= $default_val ?>"
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

<script>
	document.addEventListener("DOMContentLoaded", e => {
		new Slider(document.querySelector(".component.slider"))
	});		
</script>