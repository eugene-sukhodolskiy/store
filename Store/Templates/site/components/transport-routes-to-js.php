<?php
	$routes = [
		"FavouritesController@make" => app() -> routes -> urlto("FavouritesController@make"),
		"OrderController@new_order_page" => app() -> routes -> urlto("OrderController@new_order_page"),
		"OrderController@order_success_page" => app() -> routes -> urlto("OrderController@order_success_page"),
	];
?>

<script>
	const ROUTES = JSON.parse(`<?= json_encode($routes) ?>`);
</script>