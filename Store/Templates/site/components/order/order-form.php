<?
	/**
	 * @var UAdPost $uadpost
	 */
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
				<option value="1">Новая почта</option>
				<option value="2">Укр почта</option>
				<option value="3">Самовивоз</option>
				<option value="4">Другое</option>
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