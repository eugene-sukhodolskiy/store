<? $this -> extends_from('site.base') ?>

<?= $this -> join("\Store\Templates\Logic\SignupForm:site/components/signup-form", [
	"title" => "Signup form",
	"action" => app() -> routes -> urlto("Auth@signup", [
		"signup" => true, 
		"email" => "email@mail.com", 
		"password" => "1234", 
		"password_again" => "1234"
	]),
	"addition_classes" => ["class1", "class2"]
]) ?>