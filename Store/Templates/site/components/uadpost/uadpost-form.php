<? 
/**
 * @var String $action
 * @var String $action_to_draft
 */
?>

<div class="component uadpost-form">
	<form 
		action="<?= $action ?>" 
		data-action-submit="<?= $action ?>"
		data-action-submit-to-draft="<?= $action_to_draft ?>"
		class="form uadpost"
	>
		<div class="input-fields-container">
			<div class="form-group">
				<label for="title" class="form-label">
					Название
				</label>
				<input 
					type="text" 
					class="std-input"
					id="title"
					name="title"
					maxlength="100"
					placeholder="Название" 
				>
			</div>

			<?= $this -> join("site/components/img-uploader", [
				"number_images" => 8
			]) ?>

			<div class="form-group">
				<label for="content" class="form-label">
					Описание
				</label>
				<textarea
					class="std-input"
					id="content"
					name="content"
					maxlength="10000"
					placeholder="Опишите, что хотите продать"
				></textarea>
			</div>

			<div class="form-group condition">
				<div class="std-row">
					<div class="form-label">Состояние товара</div>
					
					<div class="std-row form-group">
						<input 
							type="radio" 
							class="std-input"
							name="condition"
							id="condition_used"
							value="used"
							title="Б/У"
							checked
						>
						<label class="form-label" for="condition_used">Б/У</label>
					</div>

					<div class="std-row form-group">
						<input 
							type="radio" 
							class="std-input"
							name="condition"
							id="condition_new"
							value="new"
							title="Новый"
						>
						<label class="form-label" for="condition_new">Новый</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="price" class="form-label">
					Цена
				</label>
				<div class="uadpost-row-fields-group price">
					<input 
						type="number" 
						class="std-input"
						id="price"
						name="price"
						max="1000000000"
						min="0"
						step="1"
						value="0"
						placeholder="Укажите цену" 
					>

					<select 
						class="std-input" 
						name="currency" 
						id="currency"
					>
						<option value="UAH">UAH</option>
						<option value="USD">USD</option>
						<option value="EUR">EUR</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<input 
					type="checkbox" 
					class="std-input" 
					name="exchange_flag"
					id="exchange_flag"
				>
				<label for="exchange_flag" class="form-label">
					Возможен обмен
				</label>
			</div>

			<hr>

			<div class="form-group">
				<label for="first_name" class="form-label">
					Ваше имя и фамилия
				</label>
				<div class="uadpost-row-fields-group username">
					<input 
						type="text" 
						class="std-input"
						id="first_name"
						name="first_name"
						maxlength="100"
						placeholder="Ваше имя"
					>
					<input 
						type="text" 
						class="std-input"
						id="second_name"
						name="second_name"
						maxlength="100"
						placeholder="Ваша фамилия" 
					>
				</div>
			</div>

			<div class="form-group">
				<label for="phone" class="form-label">
					Ваш номер телефона
				</label>
				<input 
					type="tel" 
					class="std-input"
					id="phone"
					name="phone"
					maxlength="100"
					placeholder="Ваш номер телефона" 
				>
			</div>

			<div class="form-group">
				<?= $this -> join("site/components/uadpost/select-location") ?>
			</div>

			<hr>

			<div class="form-group">
				<input 
					type="checkbox" 
					class="std-input"
					name="rules_agree" 
					id="rules_agree" 
					checked
				>
				<label for="rules_agree" class="form-label">
					Я соглашаюсь с 
					<a href="#" target="_blank">политикой конфиденциальности</a>
				</label>
			</div>

			<div class="form-group form-control-btns-container">
				<div class="uadpost-row-fields-group form-control-btns">
					<div class="submit-group">
						<button class="std-btn btn-success submit">Опубликовать</button>
						<button class="std-btn btn-primary submit-to-draft">В черновики</button>
					</div>
					<div class="cancel-group">
						<a href="#" class="std-btn btn-default cancel">Отмена</a>
					</div>
				</div>

				<div class="alert-container"></div>
			</div>
		</div>

		<div class="instructions">
			<div class="instruction-item">
				<h3>Instruction Heading</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, laborum, ut? Quae sit perspiciatis voluptatum corrupti alias cumque nesciunt molestias dolor deserunt nihil consequatur sed, reprehenderit repellendus odit, optio! Consequuntur inventore et molestias vel iste reprehenderit harum fugiat suscipit quasi, corporis consequatur pariatur molestiae vitae odio non quam similique dolores?</p>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae suscipit necessitatibus, porro atque ullam, neque, ad corporis tenetur consectetur, enim soluta id illum!</p>
			</div>
			<div class="instruction-item">
				<h3>Instruction 2 Heading</h3>
				<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur officia qui placeat impedit maiores iusto aliquam.</p>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing, elit. Molestias ullam impedit a, quaerat, excepturi ab totam, voluptates dolores sequi animi aut, consectetur?</p>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="/Store/Resources/js/UAdPostForm.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		new UAdPostForm(".component.uadpost-form");
	});
</script>