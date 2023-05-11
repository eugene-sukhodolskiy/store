class DevTools {
	constructor(component) {
		this.component = component;
		this.btnOpenPanel = this.component.querySelector(".btn-open-panel");
		this.btnClosePanel = this.component.querySelector(".btn-close-panel");
		this.panel = this.component.querySelector(".panel");

		this.init();
	}

	init() {
		this.btnOpenPanel.addEventListener("click", e => {
			this.openPanel();
		});

		this.btnClosePanel.addEventListener("click", e => {
			this.closePanel();
		});

		document.addEventListener("keydown", e => {
			if(e.code == "Escape") {
				this.closePanel();
			}

			if(e.ctrlKey && e.code == "Space") {
				this.openPanel();
			}
		});

		this.component.querySelector(".slide-toggle-tree").addEventListener("click", e => {
			const tree = this.component.querySelector(".tree");
			
			if(tree.style.display != "block") {
				utils.slideDown(tree);
			} else {
				utils.slideUp(tree);
			}

			const inverseText = e.currentTarget.dataset.inverseText;
			e.currentTarget.dataset.inverseText = e.currentTarget.innerHTML;
			e.currentTarget.innerHTML = inverseText;

		});
	}	

	openPanel() {
		this.panel.classList.remove("dnone");
	}

	closePanel() {
		this.panel.classList.add("dnone");
	}
}