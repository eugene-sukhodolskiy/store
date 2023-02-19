<?php
	/**
	 * @var Array $menu
	 */
?>

<div class="component local-menu">
	<button class="local-menu-active-btn">
		<span class="mdi mdi-dots-vertical"></span>
	</button>

	<ul class="local-menu-list">
		<? foreach($menu as $i => $item): ?>
			<li>
				<? if(isset($item["type"]) and $item["type"] == "btn"): ?>
					<button 
						class="local-menu-item <?= isset($item["class"]) ? $item["class"] : "" ?>"
						<?= isset($item["attribute"]) ? $item["attribute"] : "" ?>
					>
						<?= $item["content"] ?>
					</button>
				<? else: ?>
					<a 
						href="<?= $item["href"] ?>"
						class="local-menu-item <?= isset($item["class"]) ? $item["class"] : "" ?>"
						<?= isset($item["attribute"]) ? $item["attribute"] : "" ?>
					>
						<?= $item["content"] ?>
					</a>
				<? endif ?>
			</li>
		<? endforeach ?>
	</ul>
</div>