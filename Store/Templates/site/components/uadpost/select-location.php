<div class="component select-location">
	<div class="std-row">
		<button class="std-btn btn-primary open-select-map" role="button">Выберите местоположение</button>
		<div class="display-selected-location-outside">Выберите на карте место продажи товара</div>
	</div>

	<div class="select-location-wrap">
		<div class="select-location-map"></div>
		
		<div class="map-card">
			<h2 class="map-card-heading">Выбор местоположения</h2>

			<div class="display-selected-location">
				Выберите на карте ваше приблизительное местоположение
			</div>

			<div class="btns-group">
				<button class="std-btn btn-success apply-location disable" role="button">Подтвердить</button>
				<button class="std-btn btn-default cancel-selecting-location" role="button">Отмена</button>
			</div>
		</div>

		<button class="std-btn btn-popup-close close-select-location" role="button">
			<span class="mdi mdi-close"></span>
		</button>

		<input type="hidden" name="lat" value="">
		<input type="hidden" name="lng" value="">
		<input type="hidden" name="country_ru" value="">
		<input type="hidden" name="country_en" value="">
		<input type="hidden" name="region_ru" value="">
		<input type="hidden" name="region_en" value="">
		<input type="hidden" name="city_ru" value="">
		<input type="hidden" name="city_en" value="">
	</div>
</div>

<script async="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYKb4TgK3Ym5oiPzsTDtEf1jFMnWap3oo&amp;libraries=geometry">
</script>

<script type="text/javascript" src="/Store/Resources/js/SelectLocation.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		window.selectLocation = new SelectLocation(".select-location .display-selected-location-outside");
	});
</script>