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
			<?= $this -> join("devtools/components/action", [
				"action_type" => $action_type,
				"action_name" => $action_name,
				"action_execute_time" => $action_execute_time,
				"action_params" => $action_params
			]) ?>

			<? if($time_logs and count($time_logs)): ?>
				<?= $this -> join("devtools/components/timelogs", [
					"time_logs" => $time_logs
				]) ?>
			<? endif ?>

			<?= $this -> join("devtools/components/models", [
				"models" => $models
			]) ?>

			<?= $this -> join("devtools/components/sql-queries", [
				"sql_queries" => $sql_queries,
				"sql_summary_time" => $sql_summary_time
			]) ?>

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