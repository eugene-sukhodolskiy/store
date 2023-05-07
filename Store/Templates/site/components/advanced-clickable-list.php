<?php
	/**
	 * @var String $items
	 * @var String $addition_class
	 */
?>

<div class="component advanced-clickable-list <?= $addition_class ?? "" ?>">
	<ul class="clickable-list items-container">
		<? foreach($items as $item): ?>
			<? 
				if(isset($item["attrs"])) {
					$attrs = implode(" ", array_map(
						fn($name, $val) => "{$name}='{$val}'",
						array_keys($item["attrs"]),
						array_values($item["attrs"]) 
					));
				}
			?>
			<li class="list-item <?= $item["css_class"] ?? "" ?>" <?= $attrs ?? "" ?>><?= $item["text"] ?></li>
		<? endforeach ?>
	</ul>
</div>