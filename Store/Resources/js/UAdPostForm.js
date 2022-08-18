class UAdPostForm {
	constructor(selector) {
		this.container = document.querySelector(selector);
		this.container.getInstance = () => this;
		this.form = this.container.querySelector(".form.uadpost");
		this.alertContainer = this.container.querySelector(".alert-container");
		this.alert;

		this.initEvents();
	}

	initEvents() {
		this.form.addEventListener("submit", e => {
			e.preventDefault();
			this.submit();
		});

		this.form.querySelector(".submit").addEventListener("click", e => {
			this.form.setAttribute("action", this.form.getAttribute("data-action-submit"));
		});

		this.form.querySelector(".submit-to-draft").addEventListener("click", e => {
			this.form.setAttribute("action", this.form.getAttribute("data-action-submit-to-draft"));
		});

		this.form.querySelectorAll("input, textarea").forEach(
			input => input.addEventListener("input", e => {
				e.currentTarget.classList.remove("error");
				this.alert && this.alert.close();
			})
		);
	}

	getFormData() {
		const data = new FormData(this.form);
		const imgs = this.container.querySelector(".component.img-uploader").getInstance().getPreparedData();
		data.append(`imgs`, imgs.map(img => img.alias, imgs));
		return data;
	}

	submit() {
		if(this.form.classList.contains("disable")){
			return false;
		}

		const data = this.getFormData();

		this.form.classList.add("disable");
		this.container.querySelectorAll(".submit-group button").forEach(btn => btn.classList.add("disable"));
		this.container.querySelectorAll("input.error, textarea.error").forEach(input => input.classList.remove("error"));
		this.alert && this.alert.close();

		const xhr = new XMLHttpRequest();
		xhr.open("POST", this.form.getAttribute("action"));
		xhr.onload = () => {
			this.container.querySelectorAll(".submit-group button").forEach(btn => btn.classList.remove("disable"));
			this.form.classList.remove("disable");

			if(xhr.status == 200) {
				try {
					JSON.parse(xhr.response);
				} catch(e) {
					this.alert = createAlertComponent("danger", "Ой... Что-то пошло не так", true, true).showIn(this.alertContainer);
					console.error("JSON unvalid, maybe server error");
				}
				
				const resp = JSON.parse(xhr.response);
				console.log(resp);

				if(!resp.status) {
					for(let field of resp.failed_fields) {
						this.container.querySelector(`[name="${field}"]`).classList.add("error");
					}

					if(resp.msg) {
						this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
					}
					return;
				}

				// TODO: use text of messages by alias 
				const msg = "Успешно! Перенаправление...";
				this.alert = createAlertComponent("success", msg, true, true).showIn(this.alertContainer);
				setTimeout(() => { 
					document.location = resp.data.redirect_url; 
				}, resp.data.redirect_delay);
			} else {
				console.error("Undefined error on server")
				// TODO: use text of messages by alias 
				this.alert = createAlertComponent("danger", "Ой... Что-то пошло не так", true, true).showIn(this.alertContainer);
			}
		}

		xhr.onerror = () => {
			// TODO: displaying error
			console.error("Error of request to server");
			// TODO: use text of messages by alias 
			this.alert = createAlertComponent("danger", "Сервер не доступен", true, true).showIn(this.alertContainer);
		}

		xhr.send(data);
	}
}