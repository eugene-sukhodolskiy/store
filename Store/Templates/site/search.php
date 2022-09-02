<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="page-content-wrap">
	<div class="filters-container">
		<?= $this -> join("site/components/search-filters") ?>
	</div>
	<div class="search-result">
		<? if($total_uadposts): ?>
			<? if(strlen($search_query)): ?>
				<h3>По запросу "<?= $search_query ?>" найдено <?= $total_uadposts ?> результатов</h3>
			<? endif ?>

			<? foreach ($uadposts as $i => $uadpost): ?>
				<div class="search-item">
					<?= $this -> join("\Store\Templates\Logic\UAdPostCard:site/components/uadpost/uadpost-card.php", [
						"uadpost" => $uadpost,
						"displaying_saler" => true
					]) ?>
					
					<?= $this -> join("site/components/user/compact-user-card", [
						"user" => $uadpost -> user()
					]) ?>
				</div>
			<? endforeach ?>
		<? else: ?>
			<h3>Ничего не найдено</h3>
		<? endif ?>
	</div>
</div>
	
<?= $this -> join("\Store\Templates\Logic\Paginator:site/components/paginator", [
	"id" => "search-result-paginator",
	"per_page" => $per_page,
	"total" => $total_uadposts
]) ?>
