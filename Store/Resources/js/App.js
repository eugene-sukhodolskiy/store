class App {
	constructor() {
		console.log("App Start");

		this.search = new Search(document.querySelector(".component.search-bar"));
		this.favorite = new Favorite(document.querySelectorAll("[data-make-favorite]"));
		this.orderForm = new OrderForm(document.querySelector("form.form.order"));
		this.orders = new Orders();
		
		this.initBaseEvents();
		this.initControlPanelEvents();
		this.initPreloaders();

		document.querySelectorAll("a, button").forEach(i => {
			if(!i.getAttribute("tabindex")) {
				i.setAttribute("tabindex", -1);
			}
		})
	}

	initBaseEvents() {
		document.querySelector(".btn-nav-on-mob-show").addEventListener("click", e => {
			if(e.currentTarget.classList.contains("active")) {
				e.currentTarget.classList.remove("active");
				document.querySelectorAll(".navigation-main-wrapper, .userbar-wrapper").forEach(item => {
					item.classList.remove("show");
				});
			}else{
				e.currentTarget.classList.add("active");
				document.querySelectorAll(".navigation-main-wrapper, .userbar-wrapper").forEach(item => {
					item.classList.add("show");
				});
			}
		});

		autosize(document.querySelectorAll("textarea"));

		document.querySelectorAll(".input-counter[data-counter-for-input]").forEach(item => {
			document.querySelector(`#${item.getAttribute("data-counter-for-input")}`).addEventListener("input", e => {
				const len = e.currentTarget.value.length;
				const maxLen = parseInt(e.currentTarget.getAttribute("maxlength"));

				if(len > 0 && !item.classList.contains("show")) {
					item.classList.add("show");
				}

				if(len == 0 && item.classList.contains("show")) {
					item.classList.remove("show");
				}

				item.innerHTML = maxLen - len;
			});
		});

		document.querySelectorAll("[data-show-phone-number]").forEach(item => {
			item.addEventListener("click", e => {
				if(typeof e.currentTarget.dataset.viewFlag == "undefined") {
					e.preventDefault();
				}
				const number = e.currentTarget.getAttribute("data-show-phone-number");
				e.currentTarget.innerHTML = number;
				e.currentTarget.href = `tel:${number}`;
			})
		});

		document.querySelectorAll("[data-show-phone-number][data-uadpost-id]").forEach(item => {
			item.addEventListener("click", e => {
				if(typeof e.currentTarget.dataset.viewFlag != "undefined") {
					return false;
				}

				const uapId = e.currentTarget.dataset.uadpostId;
				e.currentTarget.dataset.viewFlag = true;
				fetch(ROUTES["UAdPostController@view_phone_number"].replace("$uap_id", uapId));
			})
		});
		
		document.addEventListener("click", e => {
			document.querySelectorAll(".component.local-menu.active").forEach(item => item.classList.remove("active"));
		});

		document.querySelectorAll(".component.local-menu .local-menu-active-btn").forEach(
			item => item.addEventListener("click", e => {
				const localMenu = e.currentTarget.parentNode;
				setTimeout(() => {
					localMenu.classList.add("active");
				}, 0);
			})
		);

		lib.collapse().init();

		document.querySelectorAll(".component.price-container").forEach(item => {
			if(item.dataset.altPriceFlag == "1") {
				item.addEventListener("click", e => {
					if(e.currentTarget.classList.contains("alt-price")) {
						e.currentTarget.classList.remove("alt-price");
					} else {
						e.currentTarget.classList.add("alt-price");
					}
				});
			}
		});
	}

	initControlPanelEvents() {
		document.querySelectorAll("[data-uadpost-remove-action]").forEach(
			item => item.addEventListener("click", e => {
				const action = e.currentTarget.getAttribute("data-uadpost-remove-action");
				confirmPopup.show({
					heading: _atxt("accept_removing"),
					applyBtnText: _atxt("remove"),
					applyBtnType: "danger",
					cancelBtnText: _atxt("cancel"),
					applyCallback: () => { 
						document.location = action;
					},
				})
			})
		);

		document.querySelectorAll("[data-uadpost-deactivate-action]").forEach(
			item => item.addEventListener("click", e => {
				const action = e.currentTarget.getAttribute("data-uadpost-deactivate-action");
				confirmPopup.show({
					heading: _atxt("deactivate_selected_uadpost"),
					applyBtnText: _atxt("deactivate"),
					applyBtnType: "warning",
					cancelBtnText: _atxt("cancel"),
					applyCallback: () => { 
						document.location = action;
					},
				})
			})
		);

		document.querySelectorAll("[data-uadpost-activate-action]").forEach(
			item => item.addEventListener("click", e => {
				const action = e.currentTarget.getAttribute("data-uadpost-activate-action");
				confirmPopup.show({
					heading: _atxt("publishing_selected_uadpost"),
					applyBtnText: _atxt("publishing"),
					applyBtnType: "success",
					cancelBtnText: _atxt("cancel"),
					applyCallback: () => { 
						document.location = action;
					},
				})
			})
		);
	}

	initPreloaders() {
		// init Preloaders 
		document.querySelectorAll(".component.preloader").forEach(i => {
			if(typeof i.getInstance == "undefined") {
				new Preloader(i);
			}
		});
	}
}

document.addEventListener("DOMContentLoaded", e => {
	window.app = new App();
});
