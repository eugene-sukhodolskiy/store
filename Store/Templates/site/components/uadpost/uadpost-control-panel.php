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

		<li class="list-item">
			<a href="#">
				<span class="mdi mdi-close-thick"></span>	
				Деактивировать
			</a>
		</li>

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

<script>
	document.addEventListener("DOMContentLoaded", e => {
		document.querySelector("[data-uadpost-remove-action]").addEventListener("click", e => {
			const action = e.currentTarget.getAttribute("data-uadpost-remove-action");
			confirmPopup.show({
				heading: "Подтвердите удаление",
				applyBtnText: "Удалить",
				applyBtnType: "danger",
				cancelBtnText: "Отмена",
				applyCallback: () => { 
					document.location = action ;
				},
			})
		});
	});
</script>