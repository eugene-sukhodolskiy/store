class Auth {
	constructor() {
		this.alert;
		this.form = document.querySelector(".auth-form .form");
		this.alertContainer = this.form.querySelector(".alert-container");
		this.submitBtn = this.form.querySelector(".submit");

		this.initEvents();
	}

	initEvents() {
		this.form.addEventListener("submit", e => {
			e.preventDefault();
			if(this.submitBtn.classList.contains("disable")){
				return false;
			}

			this.submitBtn.classList.add("disable");
			if(this.form.getAttribute("data-form-alias") == "signup") {
				this.submitSignupForm();
			}else{
				this.submitSigninForm();
			}
		});

		this.form.querySelectorAll("input[data-for-submiting]").forEach(item => {
			item.addEventListener("input", e => {
				e.currentTarget.classList.remove("error");
			})
		});

		this.form.querySelectorAll("input[data-for-submiting]").forEach(item => {
			item.addEventListener("change", e => {
				if(this.alert) {
					this.alert.close();
				}
			});
		});
	}

	submitSignupForm() {
		if(!this.form.querySelector("#terms_of_use").checked){
			this.alert = createAlertComponent("danger", _atxt("terms_of_use_not_selected"), true, true).showIn(this.alertContainer);
			this.submitBtn.classList.remove("disable");
			return false;
		}
		return this.submit();
	}

	submitSigninForm() {
		return this.submit();
	}

	submit() {
		const data = new FormData();
		const inputs = this.form.querySelectorAll("input[data-for-submiting]");

		for(let input of inputs){
			input.classList.contains("error") && input.classList.remove("error");
			data.append(input.getAttribute("name"), input.value);
		}

		if(this.alert){
			this.alert.close();
		}

		const xhr = new XMLHttpRequest();		
		xhr.open(
			"POST",
			this.form.getAttribute("action")
		);
		
		xhr.onload = () => {
			this.submitBtn.classList.remove("disable");
			
			if (xhr.status == 200) {
				const resp = JSON.parse(xhr.response);

				if(resp.status){
					this.submitBtn.classList.add("disable");
					this.alert = createAlertComponent("success", _atxt("success_and_redirecting"), true).showIn(this.alertContainer);
					setTimeout(() => { 
						document.location = resp.data.redirect_url; 
					}, resp.data.redirect_delay);
				}else{
					for(let field of resp.failed_fields){
						this.form.querySelector(`[name="${field}"]`).classList.add("error");
					}

					this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
					return false;
				}
			} else {
				console.error("Undefined error on server");
				this.alert = createAlertComponent("danger", _atxt("undefined_error"), true, true).showIn(this.alertContainer);
			}
		};

		xhr.onerror = function() {
		  console.error("Error of request to server");
			this.alert = createAlertComponent("danger", _atxt("server_not_available"), true, true).showIn(this.alertContainer);
		};
		
		xhr.send(data);
	}
}