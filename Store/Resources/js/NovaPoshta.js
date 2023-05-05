class NovaPoshta {
	constructor(component, orderInstance) {
		this.component = component;
		this.component.getInstance = () => this;
		this.orderInstance = orderInstance;
		this.addrInp = this.component.querySelector("#nova_poshta_addr");
		this.addrCityRefInp = this.component.querySelector(`[name="np_city_ref"]`);
		this.addrCityName = this.component.querySelector(`[name="np_city_name"]`);
		this.variantsList = this.component.querySelector(".variants-addrs");
		this.novaPoshtaDepartmentNumberSelectorWrap = this.component.querySelector(".nova-poshta-department-number-selector-wrap");
		this.novaPoshtaDepartmentNumber = this.component.querySelector("#np_department");
		this.novaPoshtaDepartmentNumberComponent = new Select(this.novaPoshtaDepartmentNumber);
		this.minValueLength = 2;

		this.initEvents();
	}

	initEvents() {
		this.addrInp.addEventListener("input", e => {
			const val = e.currentTarget.value;
			this.loadAndRenderCity(val);
		});

		this.addrInp.addEventListener("blur", e => {
			this.hideVariantsList();
		});

		this.addrInp.addEventListener("focus", e => {
			if(this.addrInp.value.length > this.minValueLength) {
				this.showVariantsList();
			}
		});
	}

	renderError(msg) {
		return `<div class="msg-container">${msg}</div>`;
	}

	renderList(addrs) {
		let html = `<ul class="clickable-list">`;
		for(let addr of addrs) {
			html += `<li class="list-item">
				<button 
					class="addr-item" 
					data-value="${addr.Present}" 
					data-city-ref="${addr.DeliveryCity}"
					data-city-name="${addr.MainDescription}"
				>${addr.Present}</button>
			</li>`;
		}
		html += "</ul>";

		return html;
	}

	initListEvents(html) {
		const element = document.createElement("DIV");
		element.innerHTML = html;
		element.querySelectorAll(".addr-item")?.forEach(i => {
			i.addEventListener("click", e => {
				e.preventDefault();
				this.addrInp.value = e.currentTarget.dataset.value;
				this.addrCityRefInp.value = e.currentTarget.dataset.cityRef;
				this.addrCityName.value = e.currentTarget.dataset.cityName;
				this.loadAndRenderDepartments();
				this.hideVariantsList();
			});
		});
		return element.childNodes[0];
	}

	show() {
		this.component.classList.add("show");	
	}

	hide() {
		this.component.classList.remove("show");	
	}

	showVariantsList() {
		this.variantsList.classList.add("show");
	}

	hideVariantsList() {
		this.variantsList.classList.remove("show");
	}

	showErrServerNotAvailable() {
		const msg = this.renderError("Сервер новой почты не доступен");
		this.variantsList.innerHTML = msg;
		this.showVariantsList();
	}

	loadAndRenderCity(val) {
		if(val.length <= this.minValueLength) {
			this.hideVariantsList();
			return;
		}

		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			ROUTES["NPDeliveryController@api_req"]
		);

		xhr.onload = () => {
			if (xhr.status == 200) {
				let resp = JSON.parse(xhr.response);
				
				this.variantsList.innerHTML = "";
				
				if(!resp.status) {
					// TODO: Show error in central error bar
					this.showErrServerNotAvailable();
					return false;
				}

				resp = resp.data;

				if(resp.data.length && resp.data[0].Addresses.length) {
					const list = this.initListEvents(this.renderList(resp.data[0].Addresses));
					this.variantsList.appendChild(list);
				} else {
					const msg = this.renderError("Ничего не найдено");
					this.variantsList.innerHTML = msg;
				}
				
				this.showVariantsList();

			} else {
				console.error("Request error of creating new order");
			}
		}

		xhr.onerror = () => {
			// TODO: Show error in central error bar
			this.showErrServerNotAvailable();
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
					this.showNovaPoshtaDepartmentNumberComponent();
				}

			} else {
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

		xhr.send(new URLSearchParams({
				"req": data
			})
		)
	}
	
	showNovaPoshtaDepartmentNumberComponent() {
		this.novaPoshtaDepartmentNumberSelectorWrap.style.display = "block";
		this.novaPoshtaDepartmentNumberSelectorWrap.classList.add("show");
	}
}