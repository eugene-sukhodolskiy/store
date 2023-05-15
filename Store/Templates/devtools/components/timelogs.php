<?php
	/**
	 * @var Array $time_logs
	 */
?>

<div class="devtools component timelogs">
	<table class="std-table">
		<caption>Time logs</caption>
		<thead>
			<tr>
				<th>Title</th>
				<th>Log name</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($time_logs as $log_name => $log): ?>
				<tr>
					<td><?= $log["title"] ?></td>
					<td><?= $log_name ?></td>
					<td><?= round($log["timestamp"] * 1000, 4) ?> ms</td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>