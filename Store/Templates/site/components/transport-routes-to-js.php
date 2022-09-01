<?php
	$routes = [
		"FavouritesController@make" => app() -> routes -> urlto("FavouritesController@make") 
	];
?>

<script>
	const ROUTES = JSON.parse(`<?= json_encode($routes) ?>`);
</script>