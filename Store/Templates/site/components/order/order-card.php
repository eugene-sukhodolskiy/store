<div class="component order-card">
	<?= $this -> join("site/components/local-menu.php", [ 
		"menu" => [
			[ 
				"href" => "#",
				"class" => "test",
				"content" => "<span class=\"mdi mdi-plus\"></span> Item 1"
			],
			[ 
				"type" => "btn",
				"attribute" => "data-attr='true'",
				"class" => "test2",
				"content" => "<span class=\"mdi mdi-filter-menu\"></span> Item 2"
			],
			[ 
				"type" => "btn",
				"attribute" => "data-attr='true'",
				"class" => "test2",
				"content" => "<span class=\"mdi mdi-menu\"></span> Item 3"
			]
		]
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
	</div>
	<div class="order-meta"></div>
</div>