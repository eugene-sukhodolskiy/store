class SearchableDropdown {
	constructor(component) {
		this.component = component;
		this.advancedClickableListComponent = new AdvancedClickableList(this.component.querySelector(".component.advanced-clickable-list"));
		this.searchField = this.component.querySelector("input.search");
		this.selector = this.component.querySelector(".selector");
		this.serviceMsg = this.component.querySelector(".service-msg");
		this.preloaderComponent = new Preloader(this.component.querySelector(".searchable-dropdown-preloader"));

		this.data = [];
		this.itemId = null;

		this.onChangeHandlers = []; // List of event handlers
		
		this.filterFunc = (dropdown, acl) => {
			const squery = dropdown.getSearchString().toLowerCase();
			const dataForRendering = [];

			for(let item of dropdown.data) {
				if(item.text.toLowerCase().includes(squery)) {
					dataForRendering.push(item);
				}
			}

			dropdown.renderItems(dataForRendering);
		}

		this.initData();
		this.renderItems(this.data);
		this.init();
	}

	initData() {
		this.data = [];
		const items = this.advancedClickableListComponent.getItems();
		let i = 0;
		for(let item of items) {
			const itemData = {
				"attrs": {
					"data-id": i++
				},
				"text": item.innerHTML
			};
			for(let name in item.dataset) {
				itemData["attrs"]["data-" + name] = item.dataset[name];
			}

			this.data.push(itemData);
		}
	}

	init() {
		this.searchField.addEventListener("focus", e => {
			this.advancedClickableListComponent.focus();
			this.searchField.classList.remove("error");
		});

		this.searchField.addEventListener("blur", e => {
			if(this.stateActive()){
				this.advancedClickableListComponent.blur();
			}
		});

		this.advancedClickableListComponent.addEventOnClickItem(aclComponent => {
			this.selectItem(aclComponent.getSelectedItem());
		});

		this.advancedClickableListComponent.addEventOnBlur(aclComponent => {
			this.blur();
		});

		this.advancedClickableListComponent.addEventOnFocus(aclComponent => {
			this.selector.classList.add("show");
		});

		this.searchField.addEventListener("input", e => {
			this.filtering();
		});
	}

	renderItems(items) {
		this.advancedClickableListComponent.clearItemsContainer();
		this.advancedClickableListComponent.appendItems(items);
		
		if(!items.length) {
			this.advancedClickableListComponent.component.classList.add("dnone");
			this.showNoResultsMsg();
		} else {
			this.advancedClickableListComponent.component.classList.remove("dnone");
			this.hideServiceMsg();
		}
	}

	selectItem(element) {
		this.itemId = parseInt(element.dataset.id);
		this.runChangeHandlers(this.getValue());
		this.searchField.value = element.textContent;
	}

	getValue() {
		for(let item of this.data) {
			if(item.attrs["data-id"] == this.itemId) {
				return item;
			}
		}

		return null;
	}

	getSearchString() {
		return this.searchField.value;
	}

	blur() {
		this.selector.classList.remove("show");
		this.searchField.blur();
	}

	stateActive() {
		return this.advancedClickableListComponent.isFocused();
	}

	addEventOnChange(handler) {
		if(typeof handler != "function") {
			return console.error("SearchableDropdown.addEventOnChange():", "Event handler must be a function");
		}
		this.onChangeHandlers.push(handler);
	}

	runChangeHandlers(value) {
		for(let handler of this.onChangeHandlers) {
			handler(this, value);
		}
	}

	filtering() {
		return this.filterFunc(this, this.advancedClickableListComponent);
	}

	refreshData() {
		this.initData();
		this.renderItems(this.data);
	}

	setCustomFilter(filter) {
		if(typeof filter != "function") {
			return console.error("SearchableDropdown.setCustomFilter()", "Filter must be a function");
		}
		this.filterFunc = filter;
	}

	showPreloader() {
		this.preloaderComponent.show();
	}

	hidePreloader() {
		this.preloaderComponent.hide();
	}

	showNoResultsMsg() {
		this.showServiceMsg("Нет подходящих вариантов");
	}

	showServiceMsg(msg) {
		this.serviceMsg.innerHTML = msg;
		this.serviceMsg.classList.remove("dnone");
	}

	hideServiceMsg() {
		this.serviceMsg.innerHTML = "";
		this.serviceMsg.classList.add("dnone");
	}
}