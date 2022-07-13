class Auth {
	constructor() {
		this.initEvents();
	}

	initEvents() {
		$(".signup-form form .submit").on("click", (e) => {
			e.preventDefault();
			this.signup($(".signup-form form"));
		});
	}

	signup(form) {
		const data = {};
		const inputs = form.find("input[data-for-submiting]");

		for(let input of inputs){
			input = $(input);
			data[ input.attr("name") ] = input.val();
		}

		$.post(form.attr("action"), data, (resp) => {
			if(!resp){
				// err
				return false;
			}

			resp = JSON.parse(resp);
			if(resp.status){
				// success
			}else{
				// err of data
				return false;
			}
		});
	}

	signin() {

	}

	signout() {

	}
}