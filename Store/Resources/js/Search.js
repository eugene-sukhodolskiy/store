class Search {
	constructor() {
		this.container = document.querySelector(".component.search-bar");
		this.searchFieldContainer = this.container.querySelector(".search-field-container");
		this.searchInput = this.container.querySelector(".search-field");
		this.btnSubmit = this.container.querySelector(".submit");
		this.filtersContainer = document.querySelector(".component.search-filters");
		if(this.filtersContainer) {
			this.filtersForm = this.filtersContainer.querySelector("form.form");
			this.filtersPriceRange = this.filtersContainer.querySelector(".price-range");
			this.filtersPriceFrom = this.filtersPriceRange.querySelector("#price_from");
			this.filtersPriceTo = this.filtersPriceRange.querySelector("#price_to");
			this.filtersApplyBtn = this.filtersContainer.querySelector(".apply-filters");
			this.filtersClearBtn = this.filtersContainer.querySelector(".clear-filters");
			this.timeoutOfAutoClearSearchFilters = 1000 * 60 * 30;
		}
		this.sortingForm = document.querySelector(".component.sorting");
		this.sortingComponent;

		this.initEvents();
		if(this.filtersContainer) {
			this.autoClearSearchFilters();
			this.restoreSearch();
			this.initFilters();
		}

		if(this.sortingForm){
			this.initSortingForm();
		}
	}

	initEvents() {
		this.searchInput.addEventListener("keyup", e => {
			if(e.keyCode == 13) {
				this.startSearch(e.currentTarget.value, new FormData(this.filtersForm));
			}
		});

		this.btnSubmit.addEventListener("click", e => {
			this.startSearch(this.searchInput.value, new FormData(this.filtersForm));
		});

		this.searchInput.addEventListener("focus", e => {
			this.searchFieldContainer.classList.add("infocus");
		});

		this.searchInput.addEventListener("blur", e => {
			this.searchFieldContainer.classList.remove("infocus");
		});

		document.addEventListener("keydown", e => {
			if (e.ctrlKey && (e.key === '/' || e.key === '.')) {
				this.searchInput.focus();
			}
		});
	}

	initFilters() {
		[this.filtersPriceFrom, this.filtersPriceTo].forEach(item => {
			item.addEventListener("input", e => {
				let from = this.filtersPriceFrom.value;
				let to = this.filtersPriceTo.value;

				if(from >= to) {
					const fieldName = e.currentTarget.getAttribute("name");
					if(fieldName == "price_from") {
						this.filtersPriceTo.value = Math.round(parseFloat(from) + 1);
					} else if(fieldName == "price_to") {
						this.filtersPriceFrom.value = Math.round(parseFloat(to) - 1);
					}
				}
			});
		});
		
		this.filtersForm.addEventListener("submit", e => {
			e.preventDefault();
			const formData = new FormData(e.currentTarget);
			this.startSearch(this.searchInput.value, formData);
		});

		this.filtersClearBtn.addEventListener("click", e => {
			e.preventDefault();
			this.clearSearchFilters();
			this.startSearch(e.currentTarget.value, new FormData(this.filtersForm));
		});
	}

	initSortingForm() {
		this.sortingComponent = new Sorting(this.sortingForm, this);
	}

	applySearchParamsAndSearching() {
		this.startSearch(this.searchInput.value, new FormData(this.filtersForm));
	}

	startSearch(searchString, searchFilters) {
		const filters = {};
		searchFilters.forEach((val, key) => {
			filters[key] = val;
		});

		localStorage.setItem("search_query", searchString);
		localStorage.setItem("search_filters", JSON.stringify(filters));
		localStorage.setItem("search_filters_update_at", (new Date()).getTime());

		const params = {
			s: searchString,
			...filters,
			sorting: this.sortingComponent ? this.sortingComponent.getValue() : null
		};

		let query = new URLSearchParams(params);
		let url = `/?${query}`;

		document.location = url;
	}

	autoClearSearchFilters() {
		let updateAt = localStorage.getItem("search_filters_update_at");
		if(!updateAt) {
			return false;
		}

		if((new Date()).getTime() - updateAt > this.timeoutOfAutoClearSearchFilters) {
			this.clearSearchFilters();
			return true;
		}
	}

	clearSearchFilters() {
		localStorage.removeItem("search_query");
		localStorage.removeItem("search_filters");
		localStorage.removeItem("search_filters_update_at");

		this.filtersForm.reset();
		this.filtersForm.querySelector(".radius-slider .slider").getInstance().reset();
	}

	restoreSearch() {
		let searchFilters = localStorage.getItem("search_filters");
		if(!searchFilters) {
			return false;
		}

		searchFilters = JSON.parse(searchFilters);
		if(!searchFilters["exchange_flag"]) {
			searchFilters["exchange_flag"] = "off";
		}

		for(let filterName in searchFilters) {
			if(filterName == "condition") {
				this.filtersForm.querySelectorAll(`[name="${filterName}"]`).forEach(i => {
					if(i.value == searchFilters[filterName]) {
						i.setAttribute("checked", "checked");
					} else {
						i.removeAttribute("checked");
					}
				});
			} else if(filterName == "exchange_flag") {
				const field = this.filtersForm.querySelector(`[name="${filterName}"]`);
				if(searchFilters[filterName] == "on") {
					field.setAttribute("checked", "checked");
				} else {
					field.removeAttribute("checked");
				}
			} else {
				const field = this.filtersForm.querySelector(`[name="${filterName}"]`);
				field.value = searchFilters[filterName];
				window.lib.triggerEvent(field, "change");
			}
		}
	}
}