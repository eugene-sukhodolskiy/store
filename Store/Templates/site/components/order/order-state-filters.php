<?
	/**
	 * @param Array $states 
	 */
	
	$filters = [
		"unconfirmed" => [
			"text" => "Ожидает",
			"default_state" => "enable",
			"css_class" => "label-primary"
		],

		"confirmed" => [
			"text" => "Подтверждено",
			"default_state" => "enable",
			"css_class" => "label-success"
		],

		"canceled" => [
			"text" => "Отменено",
			"default_state" => "enable",
			"css_class" => "label-danger"
		],

		"completed" => [
			"text" => "Завершено",
			"default_state" => "enable",
			"css_class" => "label-default"
		],
	];
?>

<div class="orders-filters">

	<? foreach ($filters as $state_name => $filter): ?>
		<? $state = isset($states[$state_name]) ? $states[$state_name] : $filter["default_state"]; ?>
		<button 
			class="label filter-toggle <?= $filter["css_class"] ?> <? if($state == "disable"): ?>outline<? endif ?> hoverable"
			data-filter-state-name="<?= $state_name ?>"
			data-filter-state="<?= $state ?>"
		>
			<span class="mdi mdi-checkbox-marked for-state-enable"></span>
			<span class="mdi mdi-checkbox-blank-outline for-state-disable"></span>
			<?= $filter["text"] ?>
		</button>
	<? endforeach ?>
	
</div>