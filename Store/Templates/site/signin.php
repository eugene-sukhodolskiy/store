<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<?= $this -> join("\Store\Templates\Logic\SigninForm:site/components/signin-form", [
	"title" => "Войти",
	"action" => app() -> routes -> urlto("Auth@signin"),
	"addition_classes" => []
]) ?>