class Search {
	constructor() {
		this.container = document.querySelector(".component.search-bar");
		this.searchFieldContainer = this.container.querySelector(".search-field-container");
		this.searchInput = this.container.querySelector(".search-field");
		this.btnSubmit = this.container.querySelector(".submit");

		this.initEvents();
	}

	initEvents() {
		this.searchInput.addEventListener("keyup", e => {
			if(e.keyCode == 13) {
				this.startSearch(e.currentTarget.value);
			}
		});

		this.btnSubmit.addEventListener("click", e => {
			this.startSearch(this.searchInput.value);
		});

		this.searchInput.addEventListener("focus", e => {
			this.searchFieldContainer.classList.add("infocus");
		});

		this.searchInput.addEventListener("blur", e => {
			this.searchFieldContainer.classList.remove("infocus");
		});

		document.addEventListener("keydown", e => {
			if (e.ctrlKey && e.key === '/') {
				this.searchInput.focus();
			}
		});
	}

	startSearch(searchString) {
		if(searchString.length) {
			document.location = `/?s=${searchString}`;
		} else {
			document.location = `/`;
		}
	}
}