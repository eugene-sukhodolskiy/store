class Auth {
	constructor() {
		this.alert;
		this.form = $(".signup-form form");
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
			this.submitSignupForm();
		});

		this.form.find("input[data-for-submiting]").on("input", e => {
			$(e.currentTarget).removeClass("error");
		});

		this.form.find("input[data-for-submiting]").on("change", e => {
			this.alert.close();
		});
	}

	submitSignupForm() {
		const data = {};
		const inputs = this.form.find("input[data-for-submiting]");

		for(let input of inputs){
			input = $(input);
			data[ input.attr("name") ] = input.val();
		}

		if(this.alert){
			this.alert.close();
		}

		if(!this.form.find("#terms_of_use").is(":checked")){
			this.alert = createAlertComponent("danger", "Пользовательское соглашение не выбрано", true, true).showIn(this.alertContainer);
			this.form.find(".submit").removeClass("disable");
			return false;
		}

		$.post(this.form.attr("action"), data, (resp) => {
			this.form.find(".submit").removeClass("disable");

			if(!resp){
				this.alert = createAlertComponent("danger", "Ой... Что-то пошло не так", true, true).showIn(this.alertContainer);
				return false;
			}

			resp = JSON.parse(resp);

			if(resp.status){
				this.form.find(".submit").addClass("disable");
				this.alert = createAlertComponent("success", "Регистрация успешна. Перенаправление...", true).showIn(this.alertContainer);
				document.location = "/auth/signin";
			}else{
				for(let field of resp.err_in_field){
					this.form.find(`[name="${field}"]`).addClass("error");
				}

				this.alert = createAlertComponent("danger", resp.error_msg, true, true).showIn(this.alertContainer);
				return false;
			}
		});
	}

	signin() {

	}

	signout() {

	}
}