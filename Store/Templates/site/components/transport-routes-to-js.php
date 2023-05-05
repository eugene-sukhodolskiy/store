<?php
	$routes = [
		"FavouritesController@make" => app() -> routes -> urlto("FavouritesController@make"),
		"OrderController@new_order_page" => app() -> routes -> urlto("OrderController@new_order_page"),
		"OrderController@order_success_page" => app() -> routes -> urlto("OrderController@order_success_page"),
		"NPDeliveryController@api_req" => app() -> routes -> urlto("NPDeliveryController@api_req"),
	];
?>

<script>
	const ROUTES = JSON.parse(`<?= json_encode($routes) ?>`);
</script>