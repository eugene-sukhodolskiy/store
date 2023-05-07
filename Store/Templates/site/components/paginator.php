<?php
	/**
	 * @var String $id
	 * @var Int $total
	 * @var Int $per_page
	 */
?>

<? if($displaying): ?>
	<div class="component paginator" id="<?= $id ?>">
		<? if($btn_prev_displaying): ?>
			<div class="prev-page">
				<a href="<?= $prev_page_link ?>" class="std-btn btn-default btn-prev-page">
					<span class="mdi mdi-chevron-left"></span>
				</a>
			</div>
		<? endif ?>

		<div class="page-num-selector-wrap">
			<input 
				type="number" 
				class="std-input page-num-selector" 
				step="1"
				min="1"
				data-current-url="<?= $current_url ?>"
				max="<?= $total_pages ?>"
				value="<?= $current_page_num ?>"
			>
			<span class="no-matter-text total-pages">из <?= $total_pages ?></span>
		</div>

		<? if($btn_next_displaying): ?>
			<div class="next-page">
				<a href="<?= $next_page_link ?>" class="std-btn btn-default btn-next-page">
					<span class="mdi mdi-chevron-right"></span>
				</a>
			</div>
		<? endif ?>
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", e => {
			new Paginator(document.querySelector("#<?= $id ?>"));
		});
	</script>
<? endif ?>