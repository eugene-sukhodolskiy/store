<? extract($this -> parent() -> get_inside_data()); ?>

<?= $this -> join('site/layouts/head.php', [
	'title' => $page_title,
	'page_alias' => $page_alias
]) ?>

<div class="container">
	<?= $this -> join('site/layouts/header.php', $this -> parent() -> get_inside_data()); ?>
	<?= $this -> content() ?>
	<?= $this -> join('site/layouts/footer.php') ?>
</div>

</body>
</html>
