<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="<?= $user -> profile() -> first_name ?>">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#"><?= $user -> profile() -> first_name ?> <?= $user -> profile() -> second_name ?></a>
			</div>
			<div class="no-matter-text">
				<?= $user -> statistics() -> total_saled ?> продано / 
				<?= $user -> statistics() -> total_published_uadposts ?> в продаже
			</div>
		</div>
	</div>
</div>