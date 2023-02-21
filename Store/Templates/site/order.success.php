<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="info-card result-details">
	<h1 class="info-card-heading">
		Заказ успешно оформлен
	</h1>

	<div class="info-card-body">
		<div class="success-icon-container">
			<span class="mdi mdi-check-circle"></span>
		</div>
		<div class="details">
			ID заказа <strong class="order-id"><?= $order -> id ?></strong>
		</div>
		<?= $this -> join("site/components/uadpost/uadpost-card.php", [
			"uadpost" => $order -> uadpost(),
			"displaying_saler" => true,
			"displaying_btn_favorite" => false
		]) ?>
	</div>

	<div class="info-card-footer">
		<div class="links">
			<a href="<?= app() -> routes -> urlto(
					"OrderController@orders_cur_user_page", 
					["utype" => "customer"]
				) ?>"
			>
				Мои покупки
			</a>
			<a href="<?= $order -> uadpost() -> get_url() ?>">Страница товара</a>
			<a href="/">К поиску</a>
		</div>
	</div>
</div>
