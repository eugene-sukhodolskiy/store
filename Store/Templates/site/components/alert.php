<?php
	/**
	 * TODO: Checking for $type
	 * TODO: Do outside logic about additional classes
	 */

	/**
	 * @var String $id
	 * @var String $type [ danger | warning | success | info ]
	 * @var String $content
	 * @var Boolean $is_closable
	 * @var Boolean $visible
	 */
?>

<div class="component alert<?= $type ?><? $visible ?>" data-id="<?= $id ?>">
	<div class="content"><?= $content ?></div>
	<? if($is_closable): ?>
		<button class="close-alert" data-close-alert-id="<?= $id ?>">
			<span class="mdi mdi-close"></span>
		</button>
	<? endif ?>
</div>