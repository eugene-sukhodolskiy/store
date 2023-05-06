class Sorting {
	constructor(component, searchInstance) {
		this.component = component;
		this.searchInstance = searchInstance; 
		this.component.getInstance = () => this;
		this.selectComponent = new Select(this.component.querySelector(".select"));

		this.initEvents();
	}

	initEvents() {
		this.selectComponent.addEventOnChange((select, value) => {
			this.searchInstance.applySearchParamsAndSearching();
		});
	}

	getValue() {
		return this.selectComponent.getValue();
	}
}