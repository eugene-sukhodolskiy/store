<?php
	/**
	 * @var /Store/Entities/Order $order
	 * @var String $utype [ customer or seller ]
	 */
?>

<div class="component order-card" data-order-id="<?= $order -> id ?>">
	<?= $this -> join("site/components/local-menu.php", [ 
		"menu" => $local_menu
	]) ?>

	<div class="uadpost-info">
		<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card-micro.php", [
			"uadpost" => $order -> uadpost()
		]) ?>

		<div class="user">
			<?= $this -> join("site/components/user/compact-user-card", [
				"user" => $utype == "seller" ? $order -> customer() : $order -> seller()
			]) ?>
		</div>
	</div>

	<div class="order-details">
		<div class="order-state">
			<?= $this -> join("\Store\Templates\Logic\OrderStateLabel:site/components/order/order-state-label.php", [
				"order" => $order,
				"utype" => $utype 
			]) ?>
		</div>
		
		<div class="order-phone-number">
			<span class="mdi mdi-phone"></span>
			<? if($phone_number): ?>
				<a href="tel:<?= $phone_number ?>">
					<?= $phone_number ?>
				</a>
			<? else: ?>
				Телефон не указан
			<? endif ?>
		</div>

		<div class="order-comment">
			<img 
				class="customer-userpic"
				src="<?= $customer_userpic_url ?>" 
				alt="<?= $customer_username ?>"
			>
			<span class="mdi mdi-comment-outline"></span>
			<? if(strlen($order -> comment)): ?>
				<?= $order -> comment ?>
			<? else: ?>
				<span class="no-matter-text">Коментарий отсутствует</span>
			<? endif ?>
		</div>

		<? if($order -> delivery_method === "1"): ?>
			<button class="std-btn btn-default order-delivery" data-show-delivery-details="<?= $order -> id ?>">
				<span class="mdi mdi-truck-fast-outline"></span>
				<?= $order -> get_delivery_method_text_name() ?>
				<span class="mdi mdi-chevron-down"></span>
			</button>
		<? else: ?>
			<div class="order-delivery">
				<span class="mdi mdi-truck-fast-outline"></span>
				<?= $order -> get_delivery_method_text_name() ?>
			</div>
		<? endif ?>

		<div class="order-timestamp">
			<span class="mdi mdi-calendar"></span>
			<?= $order -> get_formatted_create_at() ?>
		</div>
	</div>	
	
	<?= $this -> join("site/components/order/order-delivery-details", [
		"order" => $order
	]) ?>
</div>