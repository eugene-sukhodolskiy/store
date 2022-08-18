<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div class="markup">
	<div class="uadpost-container">
		<main class="uadpost">
			<article>
				<? if($uadpost -> has_images()): ?>
					<?= $this -> join("site/components/uadpost/carousel.php", [
						"id" => "uadpost-carousel",
						"alt_text" => $uadpost -> title,
						"imgs" => $uadpost -> get_images()
					]) ?>
				<? endif ?>

				<header class="header">
					<div class="title-wrap">
						<h1 class="title"><?= $uadpost -> title ?></h1>
					</div>
					<div class="price">
						<?= $uadpost -> price ?>
						<span class="currency"><?= $uadpost -> currency ?></span>
					</div>
				</header>
				<div class="content">
					<?= $uadpost -> content ?>
				</div>
				<footer class="metadata">
					<div class="std-row">
						<?= $this -> join("site/components/location-view", [
							"country" => $uadpost -> country_en,
							"region" => $uadpost -> region_en,
							"city" => $uadpost -> city_en
						]) ?>

						<div class="labels">
							<? if($uadpost -> condition_used == 1): ?>
								<span class="label label-success">Новый</span>
							<? elseif($uadpost -> condition_used == 2): ?>
								<span class="label">Б/У</span>
							<? endif ?>
							<? if($uadpost -> exchange_flag): ?>
								<span class="label label-warning">Возможен обмен</span>
							<? endif ?>
						</div>
					</div>

					<div class="timestamp">
						<span class="mdi mdi-calendar"></span>
						<?= $uadpost -> get_formatted_timestamp() ?>
					</div>
				</footer>
			</article>
			
			<!-- COMMENTS -->
		</main>
	</div>

	<div class="sidebar-container">
		<div class="author">
			<?= $this -> join("site/components/user/user-card.php", [
				"user" => $uadpost -> user()
			]) ?>
		</div>
	</div>
</div>
