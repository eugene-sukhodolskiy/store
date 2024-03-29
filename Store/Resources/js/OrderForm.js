class OrderForm {
	constructor(component) {
		this.component = component;
		this.alert;
		this.alertContainer = this.component?.querySelector(".alert-container");
		this.submitBtn = this.component?.querySelector("button.submit");
		this.cancelBtn = this.component?.querySelector("button.cancel");
		this.novaPoshtaGroup = this.component?.querySelector(".nova-poshta-group");
		this.deliveryMethodSelector = this.component?.querySelector("#delivery_method");

		if(this.component) {
			this.novaPoshtaComponent = new NovaPoshta(this.component.querySelector(".component.nova-poshta-addr-selector"));
			this.deliveryMethodSelectorComponent = new Select(this.deliveryMethodSelector);
		}

		this.component && (this.component.getInstance = () => this);
		this.initEvents();
		this.initOrdersControl();
	}

	initEvents() {
		document.querySelectorAll(".btn-buy[data-uadpost-alias]").forEach(btn => {
			btn.addEventListener("click", e => {
				const alias = e.currentTarget.getAttribute("data-uadpost-alias");
				document.location = ROUTES["OrderController@new_order_page"].replace("$uadpost_alias", alias);
			});
		});

		this.component?.addEventListener("submit", e => {
			e.preventDefault();
			if(!this.submitBtn.classList.contains("disable")) {
				this.createNewOrder();
			}
		});

		this.cancelBtn?.addEventListener("click", e => {
			e.preventDefault();
			document.location = e.currentTarget.getAttribute("data-cancel-url");
		});

		this.deliveryMethodSelectorComponent?.addEventOnChange((select, value) => {
			if(value == "1") {
				this.novaPoshtaComponent?.show();
			} else {
				this.novaPoshtaComponent?.hide();
			}
		});
	}

	createNewOrder() {
		const data = this.getOrderData();
		const errs = this.validateOrderData(data);

		if(errs.length) {
			return this.displayErrsOfData(errs);
		}

		return this.submitNewOrder(data);
	}
	
	getOrderData() {
		const data = new FormData(this.component);
		return data;
	}

	validateOrderData(data) {
		const errs = [];
		return errs;
	}

	submitNewOrder(data) {
		this.disableFormControlBtns();

		const xhr = new XMLHttpRequest();
		xhr.open(
			this.component.getAttribute("method"),
			this.component.getAttribute("action")
		);

		xhr.onload = () => {
			this.enableFormControlBtns();

			if (xhr.status == 200) {
				const resp = JSON.parse(xhr.response);
				if(resp.status) {
					document.location = ROUTES["OrderController@order_success_page"].replace("$order_id", resp.data.details.order_id);
				} else {
					this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
					this.lightningOfMistake(resp.failed_fields);
				}
			} else {
				// TODO: Need text of error getting from central text file
				this.alert = createAlertComponent("danger", "Request error of creating new order", true, true).showIn(this.alertContainer);
				console.error("Request error of creating new order");
			}
		}

		xhr.onerror = () => {
			// TODO: Show err text
			console.error("Request error of creating new order");
		};

		xhr.send(data); 
	}

	disableFormControlBtns() {
		this.submitBtn.classList.add("disable");
		this.cancelBtn.classList.add("disable");
	}

	enableFormControlBtns() {
		this.submitBtn.classList.remove("disable");
		this.cancelBtn.classList.remove("disable");	
	}

	initOrdersControl() {
		document.querySelectorAll("[data-order-action]").forEach(
			item => item.addEventListener("click", e => {
				const btn = e.currentTarget;
				const action = btn.getAttribute("data-order-action");
				const btnType = btn.getAttribute("data-order-btn-type");
				const heading = {
					"confirm": _atxt("confirm"),
					"cancel": _atxt("cancel_order"),
					"complete": _atxt("complete_order"),
				};
				const applyBtnText = {
					"confirm": _atxt("confirm"),
					"cancel": _atxt("confirm"),
					"complete": _atxt("confirm"),
				};
				const applyBtnType = {
					"confirm": "success",
					"cancel": "danger",
					"complete": "success",
				};
				const cancelBtnText = {
					"confirm": _atxt("cancel"),
					"cancel": _atxt("cancel"),
					"complete": _atxt("cancel"),
				};

				confirmPopup.show({
					heading: heading[btnType],
					applyBtnText: applyBtnText[btnType],
					applyBtnType: applyBtnType[btnType],
					cancelBtnText: cancelBtnText[btnType],
					applyCallback: () => { 
						lib.simpleAJAXRequest(
							action,
							(resp, alertContainer) => {
								this.alert = createAlertComponent("success", resp.data.msg, true, true).showIn(alertContainer);
								setTimeout(() => this.alert.close(), 4000);

								const orderCard = document.querySelector(`.order-card[data-order-id="${resp.data.order_id}"]`);
								orderCard.querySelector(`.order-state`).innerHTML = resp.data.order_state_label;

								if(resp.status) {
									btn.parentNode.remove();
									const localMenu = orderCard.querySelector(`.component.local-menu`);
									if(!localMenu.querySelectorAll("li").length) {
										localMenu.classList.add("dnone");
									}
								}
							},
							document.querySelector(".user-area-page .alert-container")
						);
					},
				})
			})
		);
	}

	lightningOfMistake(failed_fields) {
		if(failed_fields.length) {
			for(let field of failed_fields) {
				this.component.querySelector(`[name="${field}"]`)?.classList.add("error");
				this.component.querySelector(`.std-input.${field}`)?.classList.add("error");
			}
		}
	}
}