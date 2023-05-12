<?php
	/**
	 * @var String $action_type
	 * @var String $action_name
	 * @var Int $action_execute_time
	 * @var Array $params
	 */
?>
<div class="devtools component action">
	<table class="std-table">
		<caption>Controller</caption>
		<tbody>
			<tr>
				<th>Request type</th>
				<td><?= $action_type ?></td>
			</tr>
			<tr>
				<th>Action</th>
				<td><?= $action_name ?></td>
			</tr>
			<tr>
				<th>Execute time</th>
				<td><?= round($action_execute_time * 1000, 4) ?> ms</td>
			</tr>
			<tr>
				<th>Params</th>
				<td><?= dd($action_params, false) ?></td>
			</tr>
		</tbody>
	</table>	
</div>