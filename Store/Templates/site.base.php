<? extract($this -> parent() -> get_inside_data()); ?>

<?= $this -> join("site/components/head", [
	"title" => $page_title,
	"page_alias" => $page_alias,
	"is_auth" => $is_auth
]) ?>

<?= $this -> join("site/components/transport-routes-to-js.php") ?>
<?= $this -> join("site/components/alias-text.php") ?>

<script>
	const ISAUTH = <?= $is_auth ? "true" : "false" ?>
</script>

<?= $this -> join("site/components/navbar", [
	"is_auth" => $is_auth
]) ?>

<div class="dnone">
	<?= $this -> join("\Store\Templates\Logic\Alert:site/components/alert", [
		"id" => "reference",
		"visible" => false,
		"is_closable" => true,
		"content" => "",
	]) ?>
</div>

<?= $this -> join("site/components/confirm-popup") ?>

<div class="container">
	<div class="page-content">
		<?= $this -> content() ?>
	</div>
	
	<?= $this -> join("site/components/footer", [
		"is_auth" => $is_auth
	]) ?>
</div>

<script src="/Store/Resources/libs/autosize.min.js"></script>
<script src="/Store/Resources/js/dist/all.min.js"></script>

</body>
</html>
