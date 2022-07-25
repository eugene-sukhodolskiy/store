class Auth {
	constructor() {
		this.alert;
		this.form = $(".auth-form .form:eq(0)");
		this.alertContainer = this.form.find(".alert-container");

		this.initEvents();
	}

	initEvents() {
		this.form.find(".submit").on("click", (e) => {
			e.preventDefault();
			if($(e.currentTarget).hasClass("disable")){
				return false;
			}

			$(e.currentTarget).addClass("disable");
			if(this.form.attr("data-form-alias") == "signup") {
				this.submitSignupForm();
			}else{
				this.submitSigninForm();
			}
		});

		this.form.find("input[data-for-submiting]").on("input", e => {
			$(e.currentTarget).removeClass("error");
		});

		this.form.find("input[data-for-submiting]").on("change", e => {
			if(this.alert){
				this.alert.close();
			}
		});
	}

	submitSignupForm() {
		if(!this.form.find("#terms_of_use").is(":checked")){
			// TODO: use text of messages by alias 
			this.alert = createAlertComponent("danger", "Пользовательское соглашение не выбрано", true, true).showIn(this.alertContainer);
			this.form.find(".submit").removeClass("disable");
			return false;
		}
		return this.submit();
	}

	submitSigninForm() {
		return this.submit();
	}

	submit() {
		const data = {};
		const inputs = this.form.find("input[data-for-submiting]");

		for(let input of inputs){
			input = $(input);
			input.hasClass("error") && input.removeClass("error");
			data[ input.attr("name") ] = input.val();
		}

		if(this.alert){
			this.alert.close();
		}

		$.post(this.form.attr("action"), data, (resp) => {
			this.form.find(".submit").removeClass("disable");

			if(!resp){
				// TODO: use text of messages by alias 
				this.alert = createAlertComponent("danger", "Ой... Что-то пошло не так", true, true).showIn(this.alertContainer);
				return false;
			}

			resp = JSON.parse(resp);

			if(resp.status){
				this.form.find(".submit").addClass("disable");
				// TODO: use text of messages by alias 
				this.alert = createAlertComponent("success", "Регистрация успешна. Перенаправление...", true).showIn(this.alertContainer);
				document.location = "/auth/signin.html";
			}else{
				for(let field of resp.failed_fields){
					this.form.find(`[name="${field}"]`).addClass("error");
				}

				this.alert = createAlertComponent("danger", resp.msg, true, true).showIn(this.alertContainer);
				return false;
			}
		});
	}

	signout() {

	}
}