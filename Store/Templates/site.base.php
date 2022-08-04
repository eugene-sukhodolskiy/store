<? extract($this -> parent() -> get_inside_data()); ?>

<?= $this -> join("site/layouts/head", [
	"title" => $page_title,
	"page_alias" => $page_alias,
	"is_auth" => $is_auth
]) ?>

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

<div class="container">
	<div class="page-content">
		<?= $this -> content() ?>
	</div>
	
	<?= $this -> join("site/layouts/footer", [
		"is_auth" => $is_auth
	]) ?>
</div>

<script type="text/javascript" src="/Store/Resources/libs/autosize.min.js"></script>
<script type="text/javascript" src="/Store/Resources/js/Alert.js"></script>
<script type="text/javascript" src="/Store/Resources/js/Auth.js"></script>
<script type="text/javascript" src="/Store/Resources/js/ImgUploader.js"></script>
<script type="text/javascript" src="/Store/Resources/js/App.js"></script>

</body>
</html>
