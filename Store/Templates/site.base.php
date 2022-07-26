<? extract($this -> parent() -> get_inside_data()); ?>

<?= $this -> join("site/layouts/head", [
	"title" => $page_title,
	"page_alias" => $page_alias
]) ?>

<?= $this -> join("site/components/navbar") ?>

<div class="dnone">
	<?= $this -> join("\Store\Templates\Logic\Alert:site/components/alert", [
		"id" => "reference",
		"visible" => false,
		"is_closable" => true,
		"content" => "",
	]) ?>
</div>

<div class="container">
	<?= $this -> content() ?>
	<?= $this -> join("site/layouts/footer") ?>
</div>

</body>
</html>
