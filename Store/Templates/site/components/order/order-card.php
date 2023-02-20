<?php
	/**
	 * @var /Store/Entities/Order $order
	 */
	
	$local_menu = [];

	if($order -> state == "unconfirmed" and app() -> sessions -> auth_user() -> id != $order -> customer_id) {
		$local_menu[] = [ 
			"type" => "btn",
			"attribute" => "data-order-id=\"{$order -> id}\"",
			"class" => "order-cancel-btn",
			"content" => "<span class=\"mdi mdi-check-bold\"></span> Принять"
		];
	}
	
	if($order -> state == "unconfirmed") {
		$local_menu[] = [ 
			"type" => "btn",
			"attribute" => "data-order-id=\"{$order -> id}\"",
			"class" => "order-cancel-btn",
			"content" => "<span class=\"mdi mdi-cancel\"></span> Отменить"
		];
	} 

	$local_menu[] = [
		"type" => "btn",
		"class" => "order-remove-btn",
		"attribute" => "data-order-id=\"{$order -> id}\"",
		"content" => "<span class=\"mdi mdi-delete-outline\"></span> Удалить"
	]
?>

<div class="component order-card">
	<?= $this -> join("site/components/local-menu.php", [ 
		"menu" => $local_menu
	]) ?>

	<div class="uadpost-info">
		<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card-micro.php", [
			"uadpost" => $order -> uadpost()
		]) ?>

		<div class="seller">
			<?= $this -> join("site/components/user/compact-user-card", [
				"user" => $order -> uadpost() -> user()
			]) ?>
		</div>
	</div>

	<div class="order-details">
		<div class="order-state">
			<? if($order -> state == "confirmed"): ?>
				<span class="label order-state-label label-success">Подтверждено продавцом</span>
			<? elseif($order -> state == "unconfirmed"): ?>
				<span class="label order-state-label label-primary">Ожидает подтверждения продавцом</span>
			<? elseif($order -> state == "canceled"): ?>
				<span class="label order-state-label label-danger">Отклонено продавцом</span>
			<? else: ?>
				<span class="label label-warning">Статус заказа неизвестний</span>
			<? endif ?>
		</div>
		
		<div class="order-timestamp">
			<span class="mdi mdi-calendar"></span>
			<?= $order -> get_formatted_create_at() ?>
		</div>

		<div class="order-comment">
			<? if(strlen($order -> comment)): ?>
				<span class="mdi mdi-comment-outline"></span>
				<?= $order -> comment ?>
			<? endif ?>
		</div>

		<div class="order-delivery">
			<span class="mdi mdi-comment-outline"></span>
			<?= $order -> get_delivery_method_text_name() ?>
		</div>

		<div class="order-phone-number">
			<span class="mdi mdi-phone"></span>
			<?= $order -> uadpost() -> user() -> profile() -> phone_number ?>
		</div>
	</div>	
</div>