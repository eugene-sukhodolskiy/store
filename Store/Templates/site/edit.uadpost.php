<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h1 class="heading">Редактирование объявления</h1>
<?= $this -> join("\Store\Templates\Logic\UAdPostForm:site/components/uadpost/uadpost-form", [
	"action" => app() -> routes -> urlto("UAdPostController@update"),
	"action_to_draft" => app() -> routes -> urlto("UAdPostController@create_draft"),
	"uadpost" => $uadpost,
	"edit_mode" => true
]) ?>