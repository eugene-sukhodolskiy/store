<?php
	/**
	 * @var Array $template_map
	 * @var Int $total_template_calls
	 * @var Int $total_uniq_template_parts
	 */

	function template_tree_recursive_view($template_map, $ctx, $color = 15) {
		$bgcolor = "background-color: rgb({$color}, {$color}, {$color})";
		foreach($template_map as $name => $template) {
			echo '<div class="tree-branch" style="'. $bgcolor .'">';
			echo $ctx -> join("devtools/components/template-tree-element", [
				"name" => $name,
				"rendering_time" => $template["rendering_time"],
				"calls" => $template["calls"]
			]);

			if(is_array($template["childs"]) and count($template["childs"])) {
				template_tree_recursive_view($template["childs"], $ctx, min($color + 10, 160));
			}
			echo "</div>";
		}
	}
?>

<div class="devtools component template-tree">
	<div class="meta-info">
		<table class="std-table">
			<caption>Template info</caption>
			<tbody>
				<tr>
					<th>Unique template parts</th>
					<td><?= $total_uniq_template_parts ?></td>
				</tr>
				<tr>
					<th>Total template calls</th>
					<td><?= $total_template_calls ?></td>
				</tr>
				<tr>
					<td>
						<button class="std-link slide-toggle-tree" data-inverse-text="Hide template tree">Show template tree</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="tree" style="display: none">
		<? template_tree_recursive_view($template_map, $this) ?>
	</div>
</div>