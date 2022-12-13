<?php
	/**
	 * @var Boolean $displaying_saler
	 * @var Boolean $displaying_btn_favorite
	 * @var UAdPost $uadpost
	 */
	
	$first_img = $uadpost -> get_first_image();
?>
<div class="component uadpost-card">
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

			<div class="price-container">
				<span class="price"><?= $uadpost -> get_formatted_price() ?></span> 
				<span class="currency"><?= $uadpost -> get_formatted_currency() ?></span>
			</div>

			<div class="std-row meta-info">
				<?= $this -> join("site/components/location-view", [
					"country" => $uadpost -> country_en,
					"region" => $uadpost -> region_en,
					"city" => $uadpost -> city_en
				]) ?>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						<?= $uadpost -> get_formatted_timestamp() ?>
					</span>
				</div>
			</div>

			<? if(isset($displaying_saler) and $displaying_saler): ?>
				<div class="saler">
					<?= $this -> join("site/components/user/compact-user-card", [
						"user" => $uadpost -> user()
					]) ?>
				</div>
			<? endif ?>

			<div class="control-bar">
				<? if(isset($displaying_btn_favorite) and $displaying_btn_favorite): ?>
					<?= $this -> join("site/components/btn-favorite", [ 
						"state" => $uadpost -> is_favorite_for_current_user() ? "active" : "",
						"uadpost_id" => $uadpost -> id()
					]) ?>
				<? endif ?>
				<a href="<?= $uadpost -> get_url() ?>" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>