<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<?= $this -> join("\Store\Templates\Logic\SignupForm:site/components/signup-form", [
	"title" => "Регистрируйся",
	"action" => app() -> routes -> urlto("AuthController@signup"),
	"addition_classes" => []
]) ?>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		window.auth = new Auth();
	});
</script>