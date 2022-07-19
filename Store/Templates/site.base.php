<? extract($this -> parent() -> get_inside_data()); ?>

<?= $this -> join('site/layouts/head', [
	'title' => $page_title,
	'page_alias' => $page_alias
]) ?>

<div class="dnone">
	<?= $this -> join("\Store\Templates\Logic\Alert:site/components/alert", [
		"id" => "reference",
		"visible" => false,
		"is_closable" => true,
		"content" => "",
	]) ?>
</div>

<div class="container">
	<?= $this -> join('site/layouts/header', $this -> parent() -> get_inside_data()); ?>
	<?= $this -> content() ?>
	<?= $this -> join('site/layouts/footer') ?>
</div>

</body>
</html>
