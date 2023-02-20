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

		<div class="form-group">
			<label for="delivery_method" class="form-label">Метод доставки</label>
			<select name="delivery_method" id="delivery_method" class="std-input">
				<? foreach ($delivery_method_map as $i => $name): ?>
					<option value="<?= $i ?>"><?= $name ?></option>
				<? endforeach ?>
			</select>
		</div>
		<div class="form-group">
			<label for="comment" class="form-label">Коментарий к заказу</label>
			<textarea 
				name="comment" 
				id="comment" 
				class="std-input"
				mexlength="600"
				placeholder="Коментарий к заказу"
			></textarea>
		</div>
		<div class="alert-container"></div>
		<div class="form-gorup">
			<button class="std-btn btn-success submit">Оформить покупку</button>
			<button class="std-btn btn-default cancel" data-cancel-url="<?= $uadpost -> get_url() ?>">Отмена</button>
		</div>
	</form>
</div>