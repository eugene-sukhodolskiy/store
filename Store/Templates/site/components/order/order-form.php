<?
	/**
	 * @var UAdPost $uadpost
	 */
	
	$delivery_method_map = app() -> utils -> get_delivery_method_map();
?>

<div class="component order-form">
	<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card.php", [
		"uadpost" => $uadpost,
		"displaying_saler" => true
	]) ?>

	<form 
		action="<?= app() -> routes -> urlto('OrderController@create') ?>" 
		method="post" 
		class="form order"
	>
		<input type="hidden" name="uap_id" value="<?= $uadpost -> id() ?>">
		<input type="hidden" name="price" value="<?= $uadpost -> price ?>">
		<input type="hidden" name="currency" value="<?= $uadpost -> currency ?>">
		<input type="hidden" name="single_price" value="<?= $uadpost -> single_price ?>">

		<div class="form-group">
			<label for="delivery_method" class="form-label">Метод доставки</label>
			<? 
				$delivery_data = [];
				$default_val = "";
				foreach($delivery_method_map as $value => $text) {
					if(!$default_val) {
						$default_val = $value;
					}
					$delivery_data[] = ["text" => $text, "value" => $value];
				}
			?>
			<?= $this -> join("site/components/select", [
					"component_id" => "delivery_method",
					"tabindex" => 1,
					"input_name" => "delivery_method",
					"default_text" => "Выберите метод доставки", 
					"value" => 0,
					"variants" => $delivery_data
				]);
			?>
		</div>
		<div class="nova-poshta-group">
			<?= $this -> join("site/components/order/nova-poshta-addr-selector", [
				"default_displaying_state" => false
			]) ?>
		</div>
		<div class="form-group comment-wrap">
			<label for="comment" class="form-label">Коментарий к заказу</label>
			<textarea 
				name="comment" 
				id="comment" 
				class="std-input"
				mexlength="600"
				placeholder="Коментарий к заказу"
				tabindex="4"
			></textarea>
		</div>
		<div class="alert-container"></div>
		<div class="form-gorup">
			<button 
				class="std-btn btn-success submit" 
				tabindex="5"
			>Оформить покупку</button>
			<button 
				class="std-btn btn-default cancel" 
				data-cancel-url="<?= $uadpost -> get_url() ?>" 
				tabindex="6"
			>Отмена</button>
		</div>
	</form>
</div>