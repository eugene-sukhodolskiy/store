<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

SEARCH

<div class="filters"></div>
<div class="search-result" style="width: 600px">
	<? foreach ($uadposts as $uadpost): ?>
		<?= $this -> join("site/components/uadpost/uadpost-card.php", [
			"uadpost" => $uadpost
		]) ?>
	<? endforeach ?>
</div>
