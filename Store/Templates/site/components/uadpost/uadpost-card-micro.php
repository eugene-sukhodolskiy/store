<?php
	/**
	 * @var UAdPost $uadpost
	 */
	
	$first_img = $uadpost -> get_first_image();
?>
<div class="component uadpost-card-micro">
	<div class="struct <?= $uadpost -> has_images() ? "with-img" : "" ?>">
		
		<? if($first_img and $uadpost -> has_images()): ?>
			<div class="picture">
				<a href="<?= $uadpost -> get_url() ?>" class="no-decoration">
					<img 
						src="<?= $first_img -> get_url("md") ?>" 
						class="thumb" 
						alt="<?= $uadpost -> title ?>"
					>
				</a>
			</div>
		<? endif ?>

		<div class="description">
			<a href="<?= $uadpost -> get_url() ?>" class="title">
				<?= $uadpost -> title ?>
			</a>

			<?= $this -> join("site/components/uadpost/price-container", [
				"uadpost" => $uadpost
			]) ?>

			<div class="std-row meta-info">
				<?= $this -> join("site/components/location-view", [
					"country" => $uadpost -> country_en,
					"region" => $uadpost -> region_en,
					"city" => $uadpost -> city_en
				]) ?>
			</div>
		</div>
	</div>
</div>