<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<?= $this -> join("\Store\Templates\Logic\SigninForm:site/components/signin-form", [
	"title" => "Войти",
	"action" => app() -> routes -> urlto("AuthController@signin"),
	"addition_classes" => []
]) ?>

<script type="text/javascript" src="/Store/Resources/js/Auth.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", e => {
		window.auth = new Auth();
	});
</script>