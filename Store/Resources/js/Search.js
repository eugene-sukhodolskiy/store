class Search {
	constructor() {
		this.container = document.querySelector(".component.search-bar");
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
	}

	startSearch(searchString) {
		if(searchString.length) {
			document.location = `/?s=${searchString}`;
		} else {
			document.location = `/`;
		}
	}
}