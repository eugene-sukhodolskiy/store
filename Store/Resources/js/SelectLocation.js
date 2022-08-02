class SelectLocation {
	constructor(displayLocationContainerOutside) {
		this.mapStyle = [
			{
				"featureType": "administrative",
				"elementType": "geometry",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "poi",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "road",
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "road.arterial",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "road.highway",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "road.local",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}, {
				"featureType": "transit",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}
		];

		this.map;
		this.marker;
		this.location;

		this.selectorLocContainer = $(".select-location-wrap");
		this.displayLocationContainerInside = $(".display-selected-location");
		this.displayLocationContainerOutside = $(displayLocationContainerOutside);
		
		this.initMap();
		this.initEvents();
	}

	initMap() {
		window.addEventListener("load", () => {
			let mapOptions = {
				center: new google.maps.LatLng(50.4021702, 30.3926104),
				zoom: 4,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				disableDefaultUI: true,
				styles: this.mapStyle,
				gestureHandling: "greedy",
			};

			this.map = new google.maps.Map(document.getElementsByClassName("select-location-map")[0], mapOptions);

			google.maps.event.addListener(this.map, "click", e => {
				this.location = e.latLng;

				if(this.marker){
					this.marker.setMap(null);
				}

				this.marker = new google.maps.Marker({
					position: this.location,
					map: this.map
				});

				this.loadLocationLabels((resultEN, resultRU, lat, lng) => {
					this.selectorLocContainer.find(".apply-location").removeClass("disable");
					this.displayLocationContainerInside
						.html(`<span class="mdi mdi-map-marker-outline"></span> ${resultRU.city} ${resultRU.country}`);
				});

				google.maps.event.addListener(this.marker, "click", function(e) {
					let infoWindow = new google.maps.InfoWindow({
						content: 'Latitude: ' + this.location.lat() + '<br />Longitude: ' + this.location.lng()
					});
					infoWindow.open(this.map, this.marker);
				});
			});
		});
	}

	initEvents() {
		$(".open-select-map").on("click", e => {
			e.preventDefault();
			this.openLocationSelector();
		});

		this.selectorLocContainer.find(".close-select-location, .cancel-selecting-location").on("click", e => {
			e.preventDefault();
			this.closeLocationSelector();
		});

		this.selectorLocContainer.find(".apply-location").on("click", e => {
			e.preventDefault();
			if($(e.currentTarget).hasClass("disable")) {
				return false;
			}

			this.loadLocationLabels((resultEN, resultRU, lat, lng) => {
				this.selectorLocContainer.find(`[name="lat"]`).val(lat);
				this.selectorLocContainer.find(`[name="lng"]`).val(lng);
				this.selectorLocContainer.find(`[name="country_ru"]`).val(resultRU.country);
				this.selectorLocContainer.find(`[name="country_en"]`).val(resultEN.country);
				this.selectorLocContainer.find(`[name="region_ru"]`).val(resultRU.region);
				this.selectorLocContainer.find(`[name="region_en"]`).val(resultEN.region);
				this.selectorLocContainer.find(`[name="city_ru"]`).val(resultRU.city);
				this.selectorLocContainer.find(`[name="city_en"]`).val(resultEN.city);
				this.displayLocationContainerOutside
					.html(`<span class="mdi mdi-map-marker-outline"></span> ${resultRU.city} ${resultRU.country}`);
				$(".open-select-map").text("Изменить местоположение");
				this.closeLocationSelector();
			});
		});
	}

	loadLocationLabels(callback) {
		let lat = this.location.lat();
		let lng = this.location.lng();
		let resultEN = {};
		let resultRU = {};
		let query = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyDYKb4TgK3Ym5oiPzsTDtEf1jFMnWap3oo&language=en`;
		$.getJSON(query, resp => {
			resultEN = this.getLocationNamesFromMapRequest(resp);

			let query = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyDYKb4TgK3Ym5oiPzsTDtEf1jFMnWap3oo&language=ru`;
			$.getJSON(query, resp => {
				resultRU = this.getLocationNamesFromMapRequest(resp);
				callback(resultEN, resultRU, lat, lng);
			});
		});
	}

	openLocationSelector() {
		this.selectorLocContainer.addClass("show");
			
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				(position) => {
					const pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude,
					};

					this.map.setCenter(pos);
					this.map.setZoom(9);
				}, () => {
					console.warn("No access to geolocation");
				}
			);
		} else {
			console.warn("Browser doesn't support Geolocation");
		}
	}

	closeLocationSelector() {
		this.selectorLocContainer.removeClass("show");
	}

	getLocationNamesFromMapRequest(resp) {
		let country = "";
		let city = "";
		let region = "";
		for(let j=0; j<resp.results.length; j++){
			if(resp.results.length == 1 || resp.results[j].address_components[0].types[0] == "plus_code"){
				for(let i=0; i<resp.results[j].address_components.length; i++){
					if(resp.results[j].address_components[i].types[0] == "country"){
						country = resp.results[j].address_components[i].long_name;
					}

					if(resp.results[j].address_components[i].types[0] == "locality"){
						city = resp.results[j].address_components[i].long_name;
					}

					if(resp.results[j].address_components[i].types[0] == "administrative_area_level_1"){
						region = resp.results[j].address_components[i].long_name;
					}
				}
			}
		}

		return {
			"country": country,
			"city": city,
			"region": region
		}
	}
}
