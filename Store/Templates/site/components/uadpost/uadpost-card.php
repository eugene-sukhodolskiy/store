<div class="component uadpost-card">
	<div class="struct <?= $uadpost -> with_images() ? "with-img" : "" ?>">
		
		<? if($uadpost -> with_images()): ?>
			<div class="picture">
				<a href="<?= $uadpost -> get_url() ?>" class="no-decoration">
					<img 
						src="<?= $uadpost -> get_first_image() -> get_url() ?>" 
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

			<div class="short-content">
				<?= $uadpost -> content ?>
			</div>
			
			<div class="saler">
				<?= $this -> join("site/components/user/compact-user-card", [
					"user" => $uadpost -> user()
				]) ?>
			</div>

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