class AdvancedClickableList {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.state = false;
		this.itemsContainer = this.component.querySelector(".items-container");
		this.eventsMap = {
			"blur": [],
			"focus": [],
			"clickItem": []
		};
		this.selectedItem = null;

		this.initEvents();
	}

	initEvents() {
		this.initItems(this.itemsContainer.querySelectorAll(".list-item"));

		document.addEventListener("keydown", e => {
			if(!this.isFocused()) {
				return ;
			}

			if(e.code == "ArrowDown") {
				this.makeNextOptionActive();
			} else if(e.code == "ArrowUp") {
				this.makePrevOptionActive();
			}

			if(e.code == "Escape") {
				this.blur();
			}

			if(e.code == "Enter") {
				this.makeClickOnItem(this.itemsContainer.querySelector(".active"));
			}
		});
	}

	initItems(items) {
		for(let item of items) {
			this.initItem(item);
		}

		return items;
	}

	initItem(item) {
		item.addEventListener("click", e => {
			e.preventDefault();
			this.makeClickOnItem(e.currentTarget);
		});

		return item;
	}

	makeClickOnItem(item) {
		if(!item) {
			return ;
		}
		
		this.selectedItem = item;
		this.callEvent("clickItem");
		this.blur();
	}

	renderItem(item) {
		let css_class = item["css_class"] || "";
		let attrs = "";
		if(item["attrs"]) {
			for(const [name, value] of Object.entries(item["attrs"])) {
				attrs += `${name}='${value}' `;
			}
		}

		const element = document.createElement("DIV");
		element.innerHTML = `<li class="list-item ${css_class}" ${attrs}>${item["text"]}</li>`;

		return element.children[0];
	}

	appendItem(item) {
		item = this.renderItem(item);
		this.initItem(item);
		this.itemsContainer.appendChild(item);
	}

	appendItems(items) {
		for(let item of items) {
			this.appendItem(item);
		}
	}

	clearItemsContainer() {
		this.itemsContainer.innerHTML = "";
	}

	isFocused() {
		return this.state == "focused";
	}

	focus() {
		this.state = "focused";
		this.callEvent("focus");
	}

	blur() {
		this.state = "blurred";
		this.selectedItem = null;
		this.callEvent("blur");
	}

	makeNextOptionActive() {
		const activeListItem = this.itemsContainer.querySelector(".active");
		if(activeListItem) {			
			activeListItem.classList.remove("active");
			const nextElement = activeListItem.nextElementSibling;
			if(!nextElement) {
				this.makeNextOptionActive();
			}
			nextElement?.classList?.add("active");
		} else {
			this.itemsContainer?.children[0].classList.add("active");
		}

		this.scrollToSelectedOption();
	}

	makePrevOptionActive() {
		const activeListItem = this.itemsContainer.querySelector(".active");
		if(activeListItem) {			
			activeListItem.classList.remove("active");
			const prevElement = activeListItem.previousElementSibling;
			if(!prevElement) {
				this.makePrevOptionActive();
			}
			prevElement?.classList?.add("active");
		} else {
			this.itemsContainer?.children[this.itemsContainer?.children.length - 1]?.classList.add("active");
		}

		this.scrollToSelectedOption();
	}

	scrollToSelectedOption() {
		let scrollHeight = this.itemsContainer.scrollHeight;
		let offsetTop = this.itemsContainer.querySelector(".active").offsetTop - this.itemsContainer.querySelector(".active").clientHeight;
		this.itemsContainer.scrollTop = offsetTop;
	}

	addEventListener(evName, evHandler) {
		this.eventsMap[evName].push(evHandler);
	}

	addEventOnBlur(evHandler) {
		this.addEventListener("blur", evHandler);	
	}

	addEventOnFocus(evHandler) {
		this.addEventListener("focus", evHandler);	
	}

	addEventOnClickItem(evHandler) {
		this.addEventListener("clickItem", evHandler);	
	}

	callEvent(evName) {
		for(let handler of this.eventsMap[evName]) {
			handler(this);
		}
	}

	getSelectedItem() {
		return this.selectedItem;
	}

	getItems() {
		return this.itemsContainer.children;
	}
}