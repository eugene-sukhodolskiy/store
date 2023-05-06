<?php
	/**
	 * @var \Store\Entity\Order $order 
	 */
?>

<div class="component order-delivery-details" data-order-id="<?= $order -> id ?>">
	<div class="wrapper">
		<? if($order -> delivery_method === "1"): ?>
			<? $np_delivery = $order -> nova_poshta_delivery(); ?>
			<? if($np_delivery): ?>
				<? $department = $np_delivery -> department(); ?>
				<div class="full-addr">
					<span class="mdi mdi-map-marker"></span>
					<?= $order -> nova_poshta_delivery() -> addr ?>
				</div>
			
				<div class="department">
					<div class="description">
						<span class="mdi mdi-store-outline"></span> 
						<?= $department -> Description ?>
					</div>
			
					<div class="schedule">
						<? $current_week_day = date("l"); ?>
						<? foreach ($department -> Schedule as $day => $work_time): ?>
							<div class="week-item <?= $day == $current_week_day ? "current" : "" ?>">
								<div class="day-name"><?= app() -> utils -> dayname_translate($day, "ru") ?></div>
								<div class="work-time"><?= $work_time ?></div>
							</div>
						<? endforeach ?>
					</div>
				</div>
			<? endif ?>
		<? endif ?>
	</div>
</div>