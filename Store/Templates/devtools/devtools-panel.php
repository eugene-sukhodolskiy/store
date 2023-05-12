<div class="devtools devtools-panel">
	<button 
		class="std-btn btn-primary btn-open-panel"
		title="Ctrl + Space"
	>
		<span class="mdi mdi-dev-to"></span>
	</button>

	<div class="panel dnone">
		<button 
			class="std-btn btn-popup-close btn-close-panel"
			title="Escape"
		>
			<span class="mdi mdi-close"></span>
		</button>

		<div class="panel-elements">
			<div class="action">
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

			<div class="models">
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

			<?= $this -> join("devtools/components/template-tree", [
				"template_map" => $template_map,
				"total_template_calls" => $total_template_calls,
				"total_uniq_template_parts" => $total_uniq_template_parts
			]) ?>
		</div>
	</div>
</div>

<script>
	let devtools;

	document.addEventListener("DOMContentLoaded", e => {
		devtools = new DevTools(document.querySelector(".devtools-panel"));
	});
</script>