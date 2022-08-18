<?php
	/**
	 * @var String $alt_text
	 * @var String $id
	 * @var Array<Image> $imgs
	 */
?>

<div class="component carousel" id="<?= $id ?>">
	<div class="render-field">
		<div class="imgs-container" style="width: <?= count($imgs) ?>00%">
			<? foreach($imgs as $img): ?>
				<div class="img-item">
					<img 
						src="<?= $img -> get_url("xs") ?>"
						data-lazy-load="<?= $img -> get_url("lg") ?>"
						data-carousel-control-view="<?= $img -> get_url("original") ?>"
						alt="<?= $alt_text ?>"
					>
				</div>
			<? endforeach ?>
		</div>

		<div class="preloader-wrap hide">
			<?= $this -> join("site/components/preloader") ?>
		</div>
	</div>

	<div class="carousel-img-view">
		<button class="std-btn btn-popup-close">
			<span class="mdi mdi-close"></span>
		</button>
		
		<div class="preloader-wrap hide">
			<?= $this -> join("site/components/preloader") ?>
		</div>

		<img src="<?= $imgs[0] -> get_url("xs") ?>" alt="<?= $alt_text ?>" class="view">
	</div>

	<div class="carousel-control">
		<div class="img-previews">
			<? foreach($imgs as $i => $img): ?>
				<img 
					src="<?= $img -> get_url("xs") ?>" 
					class="img-preview-item"
					data-carousel-control-goto="<?= $i ?>"
					alt="<?= $alt_text ?>" 
				>
			<? endforeach ?>
		</div>

		<div class="arrows-btns">
			<button class="std-btn btn-default carousel-arrow disable" data-carousel-control="prev">
				<span class="mdi mdi-chevron-left"></span>
			</button>
			<button class="std-btn btn-default carousel-arrow" data-carousel-control="next">
				<span class="mdi mdi-chevron-right"></span>
			</button>
		</div>
	</div>
</div>

<script src="/Store/Resources/js/Carousel.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", e => {
		new Carousel("#<?= $id ?>")
	});
</script>