class Favorite {
	constructor(btnsSelector) {
		this.btns = document.querySelectorAll(btnsSelector);
		this.btns.forEach( btn => btn.getInstance = () => this );
		this.initEvents();
	}

	initEvents() {
		this.btns.forEach(btn => btn.addEventListener("click", e => this.make(e.currentTarget)));
	}

	make(btn) {
		const uadpostId = btn.getAttribute("data-uadpost-id");
		this.changeBtnVisualState(btn);

		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			ROUTES["FavouritesController@make"]
		);
		
		xhr.onload = () => {
			if (xhr.status == 200) {
				const resp = JSON.parse(xhr.response);
				if(resp.status) {
					// TODO: something do
				} else {
					this.changeBtnVisualState(btn);
					console.error(`Error with msg: ${resp.msg}`);
				}
			} else {
				this.changeBtnVisualState(btn);
				console.error("Request error of changing favorite status");
			}
		}

		const data = new FormData();
		data.append("uadpost_id", uadpostId);
		xhr.send(data); 
	}

	changeBtnVisualState(btn) {
		if(btn.classList.contains("active")) {
			btn.classList.remove("active");
		} else {
			btn.classList.add("active");
		}
	}

}