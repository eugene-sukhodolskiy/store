<? $this -> extends_from('site.base') ?>

<?= $this -> join("\Store\Templates\Logic\SignupForm:site/components/signup-form", [
	"title" => "Регистрируйся",
	"action" => app() -> routes -> urlto("Auth@signup"),
	"addition_classes" => []
]) ?>