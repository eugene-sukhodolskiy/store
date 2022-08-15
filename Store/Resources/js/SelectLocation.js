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

		this.selectorLocContainer = document.querySelector(".select-location-wrap");
		this.displayLocationContainerInside = document.querySelector(".display-selected-location");
		this.displayLocationContainerOutside = document.querySelector(displayLocationContainerOutside);
		
		this.initMap();
		this.initEvents();
	}

	initMap() {
		window.addEventListener("load", e => {
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
					this.selectorLocContainer.querySelector(".apply-location").classList.remove("disable");
					this.displayLocationContainerInside
						.innerHTML = `<span class="mdi mdi-map-marker-outline"></span> ${resultEN.city} ${resultEN.country}`;
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
		document.querySelector(".open-select-map").addEventListener("click", e => {
			e.preventDefault();
			this.openLocationSelector();
		});

		this.selectorLocContainer.querySelectorAll(".close-select-location, .cancel-selecting-location")
		.forEach(item => {
			item.addEventListener("click", e => {
				e.preventDefault();
				this.closeLocationSelector();
			});
		});

		this.selectorLocContainer.querySelector(".apply-location").addEventListener("click", e => {
			e.preventDefault();
			if(e.currentTarget.classList.contains("disable")) {
				return false;
			}

			this.loadLocationLabels((resultEN, resultRU, lat, lng) => {
				this.selectorLocContainer.querySelector(`[name="lat"]`).value = lat;
				this.selectorLocContainer.querySelector(`[name="lng"]`).value = lng;
				this.selectorLocContainer.querySelector(`[name="country_ru"]`).value = resultRU.country;
				this.selectorLocContainer.querySelector(`[name="country_en"]`).value = resultEN.country;
				this.selectorLocContainer.querySelector(`[name="region_ru"]`).value = resultRU.region;
				this.selectorLocContainer.querySelector(`[name="region_en"]`).value = resultEN.region;
				this.selectorLocContainer.querySelector(`[name="city_ru"]`).value = resultRU.city;
				this.selectorLocContainer.querySelector(`[name="city_en"]`).value = resultEN.city;
				this.displayLocationContainerOutside
					.innerHTML = `<span class="mdi mdi-map-marker-outline"></span> ${resultEN.city} ${resultEN.country}`;
				document.querySelector(".open-select-map").innerHTML = "Изменить местоположение";
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
		
		const xhr = new XMLHttpRequest();
		xhr.open("GET", query);
		xhr.onload = () => {
			if(!xhr.status == 200){
				console.error("Error of request");
				return false;
			}

			const resp = JSON.parse(xhr.response);
			resultEN = this.getLocationNamesFromMapRequest(resp);

			let query = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyDYKb4TgK3Ym5oiPzsTDtEf1jFMnWap3oo&language=ru`;
			const xhr2 = new XMLHttpRequest();
			xhr2.open("GET", query);
			xhr2.onload = () => {
				if(!xhr2.status == 200){
					console.error("Error of request");
					return false;
				}

				const resp = JSON.parse(xhr2.response);
				resultRU = this.getLocationNamesFromMapRequest(resp);
				callback(resultEN, resultRU, lat, lng);
			}

			xhr2.send();
		};

		xhr.send();
	}

	openLocationSelector() {
		this.selectorLocContainer.classList.add("show");
			
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
		this.selectorLocContainer.classList.remove("show");
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
