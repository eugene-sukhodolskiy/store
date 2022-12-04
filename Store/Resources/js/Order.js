class Order {
	constructor() {
		this.alert;
		this.form = document.querySelector("form.form.order");
		this.alertContainer = this.form?.querySelector(".alert-container");
		this.submitBtn = this.form?.querySelector("button.submit");
		this.cancelBtn = this.form?.querySelector("button.cancel");

		this.form && (this.form.getInstance = () => this);
		this.initEvents();
	}

	initEvents() {
		document.querySelectorAll(".btn-buy[data-uadpost-alias]").forEach(btn => {
			btn.addEventListener("click", e => {
				const alias = e.currentTarget.getAttribute("data-uadpost-alias");
				document.location = ROUTES["OrderController@new_order_page"].replace("$uadpost_alias", alias);
			});
		});

		this.form?.addEventListener("submit", e => {
			e.preventDefault();
			if(!this.submitBtn.classList.contains("disable")) {
				this.createNewOrder();
			}
		});

		this.cancelBtn?.addEventListener("click", e => {
			e.preventDefault();
			document.location = e.currentTarget.getAttribute("data-cancel-url");
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
		const data = new FormData(this.form);
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
			this.form.getAttribute("method"),
			this.form.getAttribute("action")
		);

		xhr.onload = () => {
			this.enableFormControlBtns();

			if (xhr.status == 200) {
				const resp = JSON.parse(xhr.response);
				if(resp.status) {
					// TODO: redirect to success page 
					document.location = ROUTES["OrderController@order_success_page"].replace("$order_id", resp.data.details.order_id);
				} else {
					this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
				}
			} else {
				this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
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
}