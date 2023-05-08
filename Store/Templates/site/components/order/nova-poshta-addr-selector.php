<div class="component nova-poshta-addr-selector <?= (isset($default_displaying_state) and $default_displaying_state) ? "show" : "" ?>">
	<div class="form-group addr-inp-group">
		<label for="nova_poshta_addr" class="form-label">Аддрес доставки</label>
		
		<?= $this -> join("site/components/searchable-dropdown.php", [
			"id" => "searchable-np-addr",
			"name" => "nova_poshta_addr",
			"placeholder_text" => "Введите адрес отделения",
			"maxlength" => 200,
			"input_class" => "addr-inp",
			"items" => [],
			"tabindex" => 2
		]) ?>

		<input type="hidden" name="np_city_ref" value="">
		<input type="hidden" name="np_city_name" value="">
	</div>

	<?= $this -> join("site/components/preloader", [
		"addition_class" => "nova-poshta-department-number-selector-preloader"
	]) ?>

	<div class="form-group nova-poshta-department-number-selector-group">
		<label class="form-label">Номер отделения или поштомата</label>
		<?= $this -> join("site/components/select", [
				"component_id" => "np_department",
				"tabindex" => 3,
				"input_name" => "np_department",
				"default_text" => "Выберите отделение или поштомат", 
				"value" => "",
				"variants" => []
			]);
		?>
	</div>
</div>