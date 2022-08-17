class App {
	constructor() {
		console.log("App Start");

		if(
			document.location.href.indexOf("signin.html") != -1 
			|| document.location.href.indexOf("signup.html") != -1 
		) {
			this.auth = new Auth();
		}

		this.search = new Search();
		
		this.initBaseEvents();
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
	}
}

document.addEventListener("DOMContentLoaded", e => {
	window.app = new App();
});
