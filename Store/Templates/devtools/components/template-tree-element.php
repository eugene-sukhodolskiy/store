<?php
	/**
	 * @var String $name
	 * @var Int $calls
	 * @var Float $rendering_time
	 */
	$rendering_time = round($rendering_time * 1000, 5);
?>

<div 
	class="
		devtools 
		component 
		template-tree-element
		<?= $rendering_time < 1 ? "success" : "" ?>
		<?= $rendering_time > 50 ? "warning" : "" ?>
		<?= $rendering_time > 300 ? "danger" : "" ?>
	"
>
	<div class="name">
		<?= $name ?>
	</div>
	<div class="calls">
		<?= $calls ?> calls ( <span class="rendering-time"><?= $rendering_time ?> ms</span> )
	</div>
</div>