<?php
	/**
	 * @var Array $order_state_label
	 */
?>

<span class="label order-state-label label-<?= $order_state_label["type"] ?>">
	<span class="mdi mdi-<?= $order_state_label["icon"] ?>"></span>
	<?= $order_state_label["text"] ?>
</span>