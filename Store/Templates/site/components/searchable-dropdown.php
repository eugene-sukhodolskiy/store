<?php
	/**
	 * @var String $id
	 * @var String $name
	 * @var String $input_class
	 * @var String $placeholder_text
	 * @var Int $maxlength
	 * @var Int $tabindex
	 * @var Array $items
	 */
?>

<div class="component searchable-dropdown" id="<?= $id ?>">
	<input 
		type="text" 
		class="std-input search <?= $input_class ?? "" ?>"
		id="<?= $name ?>"
		name="<?= $name ?>"
		maxlength="<?= $maxlength ?? 100 ?>"
		placeholder="<?= $placeholder_text ?? "" ?>"
		autocomplete="off"
		tabindex="<?= $tabindex ?? -1 ?>"
	>

	<?= $this -> join("site/components/preloader", [
		"addition_class" => "searchable-dropdown-preloader"
	]) ?>

	<div class="selector">
		<?= $this -> join("site/components/advanced-clickable-list", [
			"items" => $items ?? []
		]) ?>
		
		<div class="no-results dnone">Нет подходящих вариантов</div>
	</div>
</div>