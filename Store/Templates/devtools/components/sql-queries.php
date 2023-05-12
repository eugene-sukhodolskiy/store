<?php
	/**
	 * @var Array $sql_queries
	 * @var Float $sql_summary_time
	 */
?>

<div class="devtools component sql-queries">
	<table class="std-table">
		<caption>SQL queries (<?= count($sql_queries) ?> by <?= round($sql_summary_time * 1000, 4) ?> ms)</caption>
		<tbody>
			<? foreach ($sql_queries as $i => $item): ?>
				<tr>
					<th>#<?= $i + 1 ?></th>
					<td class="query-string">
						<pre readonly><?= $item["query"] ?></pre>
					</td>
					<td><?= round($item["time"] * 1000, 4) ?> ms</td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>