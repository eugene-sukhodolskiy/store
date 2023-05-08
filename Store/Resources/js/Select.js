class Select {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.viewContainer = this.component.querySelector(".current-selected");
		this.resultValueInput = this.component.querySelector("[data-name='result-value']");
		this.displayingCurrentSelected = this.component.querySelector(".displaying-current-selected");
		this.advancedClickableListComponent = new AdvancedClickableList(this.component.querySelector(".component.advanced-clickable-list"));

		this.onChangeHandlers = []; // List of event handlers

		this.initEvents();
	}

	initEvents() {
		this.displayingCurrentSelected.addEventListener("focus", e => {
			this.advancedClickableListComponent.focus();
			this.displayingCurrentSelected.classList.remove("error");
		});

		this.displayingCurrentSelected.addEventListener("blur", e => {
			if(this.stateActive()){
				this.advancedClickableListComponent.blur();
			}
		});

		this.advancedClickableListComponent.addEventOnClickItem(aclComponent => {
			this.selectOption(aclComponent.getSelectedItem());
		});

		this.advancedClickableListComponent.addEventOnBlur(aclComponent => {
			this.blurComponent();
		});

		this.advancedClickableListComponent.addEventOnFocus(aclComponent => {
			this.component.classList.add("show");
		});
	}

	addEventOnChange(handler) {
		if(typeof handler != "function") {
			return console.error("Select.addEventOnChange():", "Event handler must be a function");
		}
		this.onChangeHandlers.push(handler);
	}

	runChangeHandlers(value) {
		for(let handler of this.onChangeHandlers) {
			handler(this, value);
		}
	}

	getValue() {
		return this.resultValueInput.value;
	}

	renderOptions(options) {
		this.advancedClickableListComponent.clearItemsContainer();

		const items = [];
		for(let option of options) {
			items.push({
				"attrs": {
					"data-option-value": option.value,
					"data-option-text": option.text
				},
				"text": `<button>${option.text}</button>`
			});
		}

		this.advancedClickableListComponent.appendItems(items);	
	}

	stateActive() {
		return this.advancedClickableListComponent.isFocused();
	}

	blurComponent() {
		this.component.classList.remove("show");
		this.displayingCurrentSelected.blur();
	}

	selectOption(element) {
		const value = element.dataset.optionValue;
		const name = element.dataset.optionText;
		this.viewContainer.innerHTML = name;
		this.resultValueInput.value = value;
		this.runChangeHandlers(value);
	}

	reset() {
		this.resultValueInput.value = "";
		this.viewContainer.innerHTML = this.component.dataset.defaultText;
	}
}