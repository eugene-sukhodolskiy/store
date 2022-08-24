<div class="component uadpost-control-panel">
	<h3>Управление постом</h5>
	<ul class="std-list">
		<li>
			<a 
				href="<?= app() -> routes -> urlto("UAdPostController@edit_page", [ 
					"alias" => $uadpost -> alias . ".html" 
				]) ?>" 
				class=""
			>Редактировать</a>
		</li>
		<li>
			<a href="#" class="">Деактивировать</a>
		</li>
		<li>
			<button class="std-btn btn-danger" data-uadpost-remove="<?= $uadpost -> id() ?>">Удалить</button>
		</li>
	</ul>
</div>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		document.querySelector("[data-uadpost-remove]").addEventListener("click", e => {
			const uadpostId = e.currentTarget.getAttribute("data-uadpost-remove");
			confirmPopup.show({
				heading: "Подтвердите удаление",
				applyBtnText: "Удалить",
				applyBtnType: "danger",
				cancelBtnText: "Отмена",
				applyCallback: () => { console.log(`Apply ${uadpostId}`) },
			})
		});
	});
</script>