class Auth {
	constructor() {
		this.alert;
		this.alertContainer = $(".component.signup-form .alert-container");
		this.initEvents();
	}

	initEvents() {
		const form = $(".signup-form form");

		form.find(".submit").on("click", (e) => {
			e.preventDefault();
			if($(e.currentTarget).hasClass("disable")){
				return false;
			}

			$(e.currentTarget).addClass("disable");

			this.signup($(".signup-form form"));
		});

		form.find("input[data-for-submiting]").on("input", e => {
			$(e.currentTarget).removeClass("error");
		});

		form.find("input[data-for-submiting]").on("change", e => {
			this.alert.close();
		});
	}

	signup(form, callback) {
		const data = {};
		const inputs = form.find("input[data-for-submiting]");

		for(let input of inputs){
			input = $(input);
			data[ input.attr("name") ] = input.val();
		}

		if(this.alert){
			this.alert.close();
		}

		$.post(form.attr("action"), data, (resp) => {
			form.find(".submit").removeClass("disable");

			if(!resp){
				this.alert = createAlertComponent("danger", "Ой... Что-то пошло не так", true, true).showIn(this.alertContainer);
				return false;
			}

			resp = JSON.parse(resp);

			if(resp.status){
				this.alert = createAlertComponent("success", "Регистрация успешна :) Перенаправление...", true, true).showIn(this.alertContainer);
				// redirect to signin page
			}else{
				for(let field of resp.err_in_field){
					form.find(`[name="${field}"]`).addClass("error");
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