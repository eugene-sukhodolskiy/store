<div class="component search-filters">
	<button class="std-btn btn-default btn-toggle-filters" data-collapse-toggle=".search-filters .wrap">
		<span class="mdi mdi-filter-variant"></span>
		Фильтры
	</button>

	<div class="wrap collapse">
		<form action="." class="form">
			<div class="form-group price-range">
				<label for="price_from" class="form-label">Цена (UAH)</label>
				<div class="struct">
					<input 
						type="number" 
						name="price_from"
						id="price_from"
						class="std-input"
						min="0" 
						placeholder="От"
					>
					<span class="sep">-</span>
					<input 
						type="number" 
						name="price_to"
						id="price_to"
						class="std-input" 
						min="1"
						placeholder="До"
					>
				</div>
			</div>

			<div class="form-group radius-slider">
				<span class="form-label">Радиус поиска</span>
				<?= $this -> join("site/components/slider", [
					"form_name" => "radius",
					"unit" => "км",
					"min" => 10,
					"max" => 500,
					"default_val" => 400
				]) ?>
			</div>

			<div class="form-group condition">
				<div class="form-label">Состояние товара</div>
				
				<div class="std-row">
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
				<input 
					type="checkbox" 
					class="std-input" 
					name="exchange_flag"
					id="exchange_flag"
					checked
				>
				<label for="exchange_flag" class="form-label">
					Возможен обмен
				</label>
			</div>

			<div class="form-group std-row space-between btns">
				<button class="std-btn btn-primary apply-filters">
					Применить
				</button>
				<button class="std-btn btn-default clear-filters">
					<span class="mdi mdi-close"></span>
					Очистить
				</button>
			</div>
		</form>
	</div>
</div>