<div class="component uadpost-card">
	<div class="struct with-img">
		<div class="picture">
			<a href="#" class="no-decoration">
				<img 
					src="https://i.ebayimg.com/thumbs/images/g/LaYAAOSwDfdit2xb/s-l500.webp" 
					class="thumb" 
					alt=""
				>
			</a>
		</div>

		<div class="description">
			<a href="#" class="title">
				<?= $uadpost -> title ?>
			</a>

			<div class="short-content">
				<?= $uadpost -> content ?>
			</div>
			
			<div class="saler">
				<?= $this -> join("site/components/user/compact-user-card") ?>
			</div>

			<div class="control-bar">
				<?= $this -> join("site/components/btn-favorite", [ 
					"state" => "" 
				]) ?>
				<a href="#" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>