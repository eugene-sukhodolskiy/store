<?php
	/**
	 * @var Array $models
	 */
?>

<div class="devtools component models">
	<table class="std-table">
		<caption>Using models</caption>
		<tbody>
			<? foreach ($models as $i => $model): ?>
				<tr>
					<th>#<?= $i + 1 ?></th>
					<td><?= $model ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</div>