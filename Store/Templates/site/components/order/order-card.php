<?php
	/**
	 * @var /Store/Entities/Order $order
	 */
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
				<span class="label order-state-label label-success">
					<span class="mdi mdi-check-bold"></span>
					Подтверждено продавцом
				</span>
			<? elseif($order -> state == "unconfirmed"): ?>
				<span class="label order-state-label label-primary">
					Ожидает подтверждения продавцом
				</span>
			<? elseif($order -> state == "canceled"): ?>
				<span class="label order-state-label label-danger">
					<span class="mdi mdi-close-thick"></span>
					Отклонено продавцом
				</span>
			<? else: ?>
				<span class="label label-warning">Статус заказа неизвестний</span>
			<? endif ?>
		</div>
		
		<div class="order-phone-number">
			<span class="mdi mdi-phone"></span>
			<a href="tel:<?= $order -> uadpost() -> user() -> profile() -> phone_number ?>">
				<?= $order -> uadpost() -> user() -> profile() -> phone_number ?>
			</a>
		</div>

		<div class="order-comment">
			<span class="mdi mdi-comment-outline"></span>
			<? if(strlen($order -> comment)): ?>
				<?= $order -> comment ?>
			<? else: ?>
				<span class="no-matter-text">Коментарий отсутствует</span>
			<? endif ?>
		</div>

		<div class="order-delivery">
			<span class="mdi mdi-truck-fast-outline"></span>
			<?= $order -> get_delivery_method_text_name() ?>
		</div>

		<div class="order-timestamp">
			<span class="mdi mdi-calendar"></span>
			<?= $order -> get_formatted_create_at() ?>
		</div>
	</div>	
</div>