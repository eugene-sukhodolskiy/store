class Preloader {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
	}

	show() {
		this.component.style.display = "inline-block";
		this.component.classList.add("show");
	}

	hide() {
		this.component.classList.remove("show");
		const duration = parseFloat(getComputedStyle(this.component).transitionDuration);
		setTimeout(() => {
			this.component.style.display = "none";
		}, duration * 1000);
	}

	isVisible() {
		return this.component.classList.contains("show");
	}
}