<?php
	/**
	 * @var Boolean $displaying_saler
	 */
?>
<div class="component uadpost-card">
	<div class="struct <?= $uadpost -> with_images() ? "with-img" : "" ?>">
		
		<? if($uadpost -> with_images()): ?>
			<div class="picture">
				<a href="<?= $uadpost -> get_url() ?>" class="no-decoration">
					<img 
						src="<?= $uadpost -> get_first_image() -> get_url("md") ?>" 
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
				<span class="price"><?= $uadpost -> price ?></span> 
				<span class="currency"><?= $uadpost -> currency ?></span>
			</div>

			<div class="std-row meta-info">
				<div class="location">
					<span class="mdi mdi-map-marker-outline"></span>
					<span class="country"><?= $uadpost -> country_en ?></span>
					<span class="region"><?= $uadpost -> region_en ?></span>
					<span class="city"><?= $uadpost -> city_en ?></span>
				</div>
				
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
				<?= $this -> join("site/components/btn-favorite", [ 
					"state" => "",
					"uadpost_id" => $uadpost -> id()
				]) ?>
				<a href="<?= $uadpost -> get_url() ?>" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>