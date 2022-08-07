<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h1 class="heading">Новое объявление</h1>
<?= $this -> join("site/components/uadpost/uadpost-form", [
	"action" => app() -> routes -> urlto("UAdPostController@create"),
	"action_to_draft" => app() -> routes -> urlto("UAdPostController@create_draft")
]) ?>