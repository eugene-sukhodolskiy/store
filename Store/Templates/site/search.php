<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="page-content-wrap">
	<div class="filters-container"></div>
	<div class="search-result">
		<? foreach ($uadposts as $i => $uadpost): ?>
			<div class="search-item">
				<?= $this -> join("site/components/uadpost/uadpost-card.php", [
					"uadpost" => $uadpost,
					"displaying_saler" => true
				]) ?>
				
				<?= $this -> join("site/components/user/compact-user-card", [
					"user" => $uadpost -> user()
				]) ?>
			</div>
		<? endforeach ?>
	</div>
</div>
	
<?= $this -> join("\Store\Templates\Logic\Paginator:site/components/paginator", [
	"id" => "search-result-paginator",
	"per_page" => $per_page,
	"total" => $total_uadposts
]) ?>
