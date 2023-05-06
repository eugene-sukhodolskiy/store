class Select {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.viewContainer = this.component.querySelector(".current-selected");
		this.resultValueInput = this.component.querySelector("[data-name='result-value']");
		this.displayingCurrentSelected = this.component.querySelector(".displaying-current-selected");
		this.optionsContainer = this.component.querySelector(".clickable-list");
		this.onChangeHandlers = []; // List of event handlers

		this.initEvents();
	}

	initEvents() {
		this.initOptions();

		this.displayingCurrentSelected.addEventListener("click", e => {
			setTimeout(() => {
				this.component.classList.toggle("show");
			}, 10);
		});

		document.addEventListener("click", e => {
			this.blurComponent();
		});

		document.addEventListener("keydown", e => {
			if(!this.stateActive()) {
				return ;
			}

			if(e.code == "ArrowDown") {
				this.makeNextOptionActive();
			} else if(e.code == "ArrowUp") {
				this.makePrevOptionActive();
			}

			if(e.code == "Escape") {
				this.blurComponent();
			}

			if(e.code == "Enter") {
				this.selectOption(this.optionsContainer.querySelector(".active"));
				this.blurComponent();
			}
		});
	}

	initOptions() {
		this.optionsContainer.querySelectorAll("[data-option-value]").forEach(item => {
			item.addEventListener("click", e => {
				e.preventDefault();
				this.selectOption(e.currentTarget);
			});
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
		let html = "";
		for(let option of options) {
			html += `<li class="list-item">
					<button data-option-value='${option.value}'>${option.text}</button>
				</li>`;
		}

		this.optionsContainer.innerHTML = html;
		this.initOptions();
	}

	stateActive() {
		return this.component.classList.contains("show");
	}

	makeNextOptionActive() {
		const activeListItem = this.optionsContainer.querySelector(".active");
		if(activeListItem) {			
			activeListItem.classList.remove("active");
			const nextElement = activeListItem.parentNode?.nextElementSibling;
			if(!nextElement) {
				this.makeNextOptionActive();
			}
			nextElement?.children[0].classList.add("active");
		} else {
			this.optionsContainer?.children[0]?.children[0].classList.add("active");
		}

		this.scrollToSelectedOption();
	}

	makePrevOptionActive() {
		const activeListItem = this.optionsContainer.querySelector(".active");
		if(activeListItem) {			
			activeListItem.classList.remove("active");
			const prevElement = activeListItem.parentNode?.previousElementSibling;
			if(!prevElement) {
				this.makePrevOptionActive();
			}
			prevElement?.children[0].classList.add("active");
		} else {
			this.optionsContainer?.children[this.optionsContainer?.children.length - 1]?.children[0].classList.add("active");
		}

		this.scrollToSelectedOption();
	}

	scrollToSelectedOption() {
		let scrollHeight = this.optionsContainer.scrollHeight;
		let offsetTop = this.optionsContainer.querySelector(".active").parentNode.offsetTop - this.optionsContainer.querySelector(".active").parentNode.clientHeight;
		this.optionsContainer.scrollTop = offsetTop;
	}

	blurComponent() {
		if(this.component.classList.contains("show")) {
			this.component.classList.remove("show");
		}
	}

	selectOption(element) {
		const value = element.dataset.optionValue;
		const name = element.innerHTML;
		this.viewContainer.innerHTML = name;
		this.resultValueInput.value = value;
		this.runChangeHandlers(value);
	}

	reset() {
		this.resultValueInput.value = "";
		this.viewContainer.innerHTML = this.component.dataset.defaultText;
	}
}