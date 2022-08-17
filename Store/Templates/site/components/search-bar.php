<div class="component search-bar">
	<div class="form-group search-field-container">
		<input 
			type="text" 
			name="search" 
			class="std-input search-field"
			value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>"
			placeholder="Поиск"
		>
		<button class="submit">
			<span class="mdi mdi-magnify"></span>
		</button>
	</div>
</div>