class Orders {
	constructor() {
		this.initEvents();
	}

	initEvents() {
		document.querySelectorAll("[data-show-delivery-details]").forEach(i => {
			i.addEventListener("click", e => {
				const detailsComponent = document.querySelector(`.order-delivery-details[data-order-id="${e.currentTarget.dataset.showDeliveryDetails}"]`);
				if(detailsComponent.style.display == "block") {
					e.currentTarget.classList.remove("opened");
					utils.slideUp(detailsComponent);
				} else {
					e.currentTarget.classList.add("opened");
					utils.slideDown(detailsComponent);
				}
			})
		});

		document.querySelectorAll(".orders-filters .filter-toggle").forEach(item => {
			item.addEventListener("click", e => {
				const filterState = e.currentTarget.dataset.filterState;
				const filterStateName = e.currentTarget.dataset.filterStateName;
				if(filterState == "enable") {
					e.currentTarget.dataset.filterState = "disable";
					e.currentTarget.classList.add("outline");
				} else {
					e.currentTarget.dataset.filterState = "enable";
					e.currentTarget.classList.remove("outline");
				}

				const toggles = document.querySelectorAll(".orders-filters .filter-toggle");
				const excludingStates = [];
				for(let toggle of toggles) {
					if(toggle.dataset.filterState == "disable") {
						excludingStates.push(toggle.dataset.filterStateName);
					}
				}

				const searchParams = new URLSearchParams(document.location.search);
				if(searchParams.has("excluding")) {
					searchParams.delete("excluding");
				}
				
				if(excludingStates.length) {
					searchParams.append("excluding", excludingStates.join(","));
				}

				document.location.search = searchParams.toString();
			})
		});
	}
}