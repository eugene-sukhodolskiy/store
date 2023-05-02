class Sorting {
	constructor(container, searchInstance) {
		this.container = container;
		this.searchInstance = searchInstance; 
		this.container.getInstance = () => this;
		this.viewContainer = this.container.querySelector(".current-selected");
		this.resultValueInput = this.container.querySelector("[data-name='result-value']");
		this.displayingCurrentSelected = this.container.querySelector(".displaying-current-selected");

		this.initEvents();
	}

	initEvents() {
		this.container.querySelectorAll("[data-select-sorting-by]").forEach(item => {
			item.addEventListener("click", e => {
				const value = e.currentTarget.dataset.selectSortingBy;
				const name = e.currentTarget.innerHTML;
				this.viewContainer.innerHTML = name;
				this.resultValueInput.value = value;
				this.searchInstance.applySearchParamsAndSearching();
			});
		});

		this.displayingCurrentSelected.addEventListener("click", e => {
			this.container.classList.toggle("show")
		})

		document.addEventListener("click", e => {
			if(this.container.classList.contains("show")) {
				this.container.classList.remove("show");
			}
		})
	}

	getValue() {
		return this.resultValueInput.value
	}
}