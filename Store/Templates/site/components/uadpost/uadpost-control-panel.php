<div class="component uadpost-control-panel">
	<h3>Управление постом</h3>
	<ul class="clickable-list">
		<li class="list-item">
			<a 
				href="<?= app() -> routes -> urlto("UAdPostController@edit_page", [ 
					"alias" => $uadpost -> alias . ".html" 
				]) ?>" 
			>
				<span class="mdi mdi-pencil"></span>	
				Редактировать
			</a>
		</li>

		<? if($uadpost -> state == "published"): ?>
			<li class="list-item">
				<button 
					data-uadpost-deactivate-action="<?= app() -> routes -> urlto("UAdPostController@deactivate_uadpost", [ 
						"uadpost_id" => $uadpost -> id() 
					]) ?>"
				>
					<span class="mdi mdi-close-thick"></span>	
					Деактивировать
				</button>
			</li>
		<? elseif($uadpost -> state == "unpublished"): ?>
			<li class="list-item">
				<button 
					data-uadpost-activate-action="<?= app() -> routes -> urlto("UAdPostController@activate_uadpost", [ 
						"uadpost_id" => $uadpost -> id() 
					]) ?>"
				>
					<span class="mdi mdi-check-bold"></span>	
					Активировать
				</button>
			</li>
		<? endif ?>

		<li class="list-item">
			<button 
				data-uadpost-remove-action="<?= app() -> routes -> urlto("UAdPostController@remove", [
					"uadpost_id" => $uadpost -> id()
				]) ?>"
			>
				<span class="mdi mdi-delete-outline"></span>	
				Удалить
			</button>
		</li>
	</ul>
</div>