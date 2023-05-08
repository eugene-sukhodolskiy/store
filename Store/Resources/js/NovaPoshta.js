class NovaPoshta {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.addrCityRefInp = this.component.querySelector(`[name="np_city_ref"]`);
		this.addrCityName = this.component.querySelector(`[name="np_city_name"]`);
		this.searchableDropdownComponent = new SearchableDropdown(this.component.querySelector("#searchable-np-addr"));

		this.novaPoshtaDepartmentNumberSelectorWrap = this.component.querySelector(".nova-poshta-department-number-selector-group");
		this.novaPoshtaDepartmentNumber = this.component.querySelector("#np_department");
		this.novaPoshtaDepartmentNumberComponent = new Select(this.novaPoshtaDepartmentNumber);
		this.novaPoshtaDepartmentNumberPreloaderComponent = new Preloader(this.component.querySelector(".nova-poshta-department-number-selector-preloader"));
		
		this.minValueLength = 1;

		this.init();
	}

	init() {
		this.searchableDropdownComponent.showServiceMsg("Начните вводить название");

		this.searchableDropdownComponent.setCustomFilter((dropdown, acl) => {
			const searchString = dropdown.getSearchString().toLowerCase();
			if(searchString.length <= this.minValueLength) {
				dropdown.showServiceMsg("Начните вводить название");
			}	else {
				this.loadAndRenderCity(searchString);
			}
		});

		this.searchableDropdownComponent.addEventOnChange((dropdown, data) => {
			this.addrCityRefInp.value = data.attrs["data-cityRef"];
			this.addrCityName.value = data.attrs["data-cityName"];
			this.loadAndRenderDepartments();
			this.searchableDropdownComponent.blur();
		});
	}

	renderList(addrs) {
		const dataForRendering = [];
		for(let addr of addrs) {
			dataForRendering.push({
				"text": `<button tabindex="-1">${addr.Present}</button>`,
				"attrs": {
					"data-value": addr.Present,
					"data-city-ref": addr.DeliveryCity,
					"data-city-name": addr.MainDescription
				}
			});
		}

		this.searchableDropdownComponent.renderItems(dataForRendering);
		this.searchableDropdownComponent.refreshData();
	}

	show() {
		this.component.classList.add("show");	
	}

	hide() {
		this.component.classList.remove("show");	
	}

	showErrServerNotAvailable() {
		this.searchableDropdownComponent.showServiceMsg("Сервер новой почты не доступен");
	}

	loadAndRenderCity(val) {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			ROUTES["NPDeliveryController@api_req"]
		);

		xhr.onload = () => {
			this.searchableDropdownComponent.hidePreloader();

			if (xhr.status == 200) {
				let resp = JSON.parse(xhr.response);
				
				if(!resp.status) {
					this.showErrServerNotAvailable();
					return false;
				}

				resp = resp.data;

				if(resp.data.length && resp.data[0].Addresses.length) {
					this.renderList(resp.data[0].Addresses);
				} else {
					this.renderList([]);
					this.searchableDropdownComponent.showServiceMsg("Ничего не найдено")
				}
			} else {
				this.showErrServerNotAvailable();
				console.error("Request error of creating new order");
			}
		}

		xhr.onerror = () => {
			this.showErrServerNotAvailable();
			this.searchableDropdownComponent.hidePreloader();
			console.error("Request error of creating new order");
		};

		const data = JSON.stringify({
			"modelName": "Address",
			"calledMethod": "searchSettlements",
			"methodProperties": {
				"CityName": val,
				"Limit": "10",
				"Page": "1"
			}
		});

		this.searchableDropdownComponent.showPreloader();
		xhr.send(new URLSearchParams({
				"req": data
			})
		)
	}

	loadAndRenderDepartments(val) {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			ROUTES["NPDeliveryController@api_req"]
		);

		xhr.onload = () => {
			if (xhr.status == 200) {
				let resp = JSON.parse(xhr.response);
				
				if(!resp.status) {
					return false;
				}

				resp = resp.data;

				if(resp.data.length) {
					const dataStruct = [];
					for(let i in resp.data) {
						dataStruct.push({
							"text": resp.data[i].Description,
							"value": JSON.stringify({
								"SiteKey": resp.data[i].SiteKey,
								"Number": resp.data[i].Number,
								"Description": resp.data[i].Description,
								"DescriptionRu": resp.data[i].DescriptionRu,
								"Latitude": resp.data[i].Latitude,
								"Longitude": resp.data[i].Longitude,
								"Schedule": resp.data[i].Schedule,
								"PlaceMaxWeightAllowed": resp.data[i].PlaceMaxWeightAllowed
							}) 
						});
					}

					this.novaPoshtaDepartmentNumberComponent.renderOptions(dataStruct);
				} else {
					this.novaPoshtaDepartmentNumberComponent.renderOptions([]);
				}
				
				this.showNovaPoshtaDepartmentNumberComponent();

			} else {
				// TODO: Show error in central error bar
				console.error("Request error of creating new order");
			}
		}

		xhr.onerror = () => {
			// TODO: Show error in central error bar
			console.error("Request error of creating new order");
		};

		const data = JSON.stringify({
			"modelName": "Address",
			"calledMethod": "getWarehouses",
			"methodProperties": {
				"CityName": this.addrCityName.value,
				"CityRef": this.addrCityRefInp.value,
				"Page": "1",
				"Limit": "1000",
			}
		});

		this.novaPoshtaDepartmentNumberPreloaderComponent.show();
		this.hideNovaPoshtaDepartmentNumberComponent();
		xhr.send(new URLSearchParams({
				"req": data
			})
		)
	}
	
	showNovaPoshtaDepartmentNumberComponent() {
		this.novaPoshtaDepartmentNumberSelectorWrap.style.display = "block";
		this.novaPoshtaDepartmentNumberPreloaderComponent.hide();
		this.novaPoshtaDepartmentNumberSelectorWrap.classList.add("show");
	}

	hideNovaPoshtaDepartmentNumberComponent() {
		this.resetNovaPoshtaDepartmentNumberValue();
		this.novaPoshtaDepartmentNumberSelectorWrap.style.display = "block";
		this.novaPoshtaDepartmentNumberSelectorWrap.classList.remove("show");
	}

	resetNovaPoshtaDepartmentNumberValue() {
		this.novaPoshtaDepartmentNumberComponent.reset();
	}
}