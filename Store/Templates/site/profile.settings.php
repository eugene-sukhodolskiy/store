<?= $this -> extends_from("\Store\Templates\Logic\UserArea:user.area") ?>

<div class="notification-save-success dnone"></div>

<div class="profile-settings-container">
	<form action="<?= app() -> routes -> urlto("ProfileSettingsController@update") ?>" method="post">
		<div class="form-block">
			<div class="form-group">
				<label class="form-label" for="first_name">Ваше имя</label>
				<input 
					type="text" 
					name="first_name" 
					id="first_name" 
					class="std-input"
					placeholder="Как Вас зовут?"
					value="<?= $user -> profile() -> first_name ?>"
				>
			</div>

			<div class="form-group">
				<label class="form-label" for="second_name">Ваша фамилия</label>
				<input 
					type="text" 
					name="second_name" 
					id="second_name" 
					class="std-input"
					placeholder="Введите Вашу фамилию"
					value="<?= $user -> profile() -> second_name ?>"
				>
			</div>

			<div class="form-group">
				<label class="form-label" for="phone_number">Ваш номер телефона</label>
				<input 
					type="phone" 
					name="phone_number" 
					id="phone_number" 
					class="std-input"
					placeholder="Введите Ваш номер телефона"
					value="<?= $user -> profile() -> phone_number ?>"
				>
			</div>
		</div>

		<div class="form-block">
			<div class="form-group">
				<?= $this -> join("site/components/uadpost/select-location", [
					"help_text" => "Выберите ваше местоположение",
					"lat" => $user -> profile() -> location_lat,
					"lng" => $user -> profile() -> location_lng,
					"country_en" => $user -> profile() -> country_en,
					"country_ru" => $user -> profile() -> country_ru,
					"city_en" => $user -> profile() -> city_en,
					"city_ru" => $user -> profile() -> city_ru,
					"region_en" => $user -> profile() -> region_en,
					"region_ru" => $user -> profile() -> region_ru,
				]) ?>
			</div>
		</div>

		<div class="form-block">
			<div class="form-group">
				<label class="form-label">Загрузите аватар</label>
				<?= $this -> join("site/components/img-uploader", [
					"number_images" => 1,
					"images" => $images
				]) ?>
			</div>
		</div>

		<div class="form-block">
			<button class="std-btn btn-primary">Сохранить</button>
		</div>
	</form>
</div>	

<script>
	document.addEventListener("DOMContentLoaded", e => {
		if(document.location.hash.indexOf("save-success") != -1) {
			document.location.hash = "";
			document.querySelector(".notification-save-success").classList.remove("dnone");
			createAlertComponent("success", "Изменения сохранены", true, true).showIn(document.querySelector(".notification-save-success"));
		}

		document.querySelector(".profile-settings-container form").addEventListener("submit", e => {
			const imgsField = e.currentTarget.querySelector(`[name="imgs"]`);
			imgsField.type = "text";
			imgsField.value = document.querySelector(".profile-settings-container .img-uploader").getInstance().getPreparedData()[0].alias;
		});
	});
</script>

