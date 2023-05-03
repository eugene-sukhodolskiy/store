<div class="component nova-poshta-addr-selector <?= (isset($default_displaying_state) and $default_displaying_state) ? "show" : "" ?>">
	<div class="form-group">
		<label for="nova_poshta_addr" class="form-label">Аддрес доставки</label>
		<input 
			type="text" 
			class="std-input"
			id="nova_poshta_addr"
			name="nova_poshta_addr"
			maxlength="200"
			placeholder="Введите адрес отделения"
		>

		<input type="hidden" name="city_ref" value="">

		<div class="variants-addrs"></div>
	</div>

	<div class="form-group">
		<!-- TODO: Create and use component of custom select -->
		<label for="nova_poshta_addr" class="form-label">Номер отделения или поштомата</label>
		<input 
			type="text" 
			class="std-input"
			id="nova_poshta_department_number"
			name="nova_poshta_department_number"
			maxlength="200"
			placeholder="выберите нужное отделение"
		>
	</div>
</div>