class Slider {
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.val = 0;
		this.startTrackMoving = false;

		this.min = parseInt(this.component.getAttribute("data-min-val"));
		this.max = parseInt(this.component.getAttribute("data-max-val"));
		this.start = this.component.getAttribute("data-val");
		this.defaultVal = this.component.getAttribute("data-default-val");
		this.formValContainer = this.component.querySelector(".form-value-container");

		this.bar = this.component.querySelector(".bar");
		this.track = this.component.querySelector(".track");
		this.manipulator = this.component.querySelector(".manipulator");
		this.currentSliderVal = this.component.querySelector(".current-slider-val");
		this.manipulatorWidth = this.manipulator.offsetWidth;

		this.setPos(this.start);

		this.initEvents();
	}

	setPos(val) {
		this.bar.style.width = (val / (this.max - this.min) * 100) + "%";
		this.manipulator.style.left = (val / (this.max - this.min) * 100) + "%";
		this.currentSliderVal.innerHTML = val
		this.val = val;
	}

	reset() {
		this.setPos(this.defaultVal);
	}

	initEvents() {
		["mousedown", "touchstart"].forEach( 
			evName => this.manipulator.addEventListener(
				evName, 
				e => this.startTrackMoving = true 
			)
		);

		["mouseup", "touchend"].forEach(
			evName => document.addEventListener(
				evName, 
				e => this.startTrackMoving = false
			)
		);

		["mousedown", "mousemove", "touchstart", "touchmove"].forEach(
			evName => document.addEventListener(
				evName, 
				e => {
					if(!this.startTrackMoving) return;
					let pageY = e.pageY || e.changedTouches[0].pageY;
					let pageX = e.pageX || e.changedTouches[0].pageX;

					if(Math.abs(pageY - this.track.offsetTop) > this.manipulatorWidth / 2){
						this.startTrackMoving = false;
					}

					const offset = pageX - this.track.offsetLeft;
					const thisTrackWidth = this.track.offsetWidth;
					let valInPercent = Math.max(0, Math.min(100, offset / thisTrackWidth * 100));
					this.val = this.min + valInPercent / 100 * (this.max - this.min);
					this.formValContainer.value = Math.round(this.val);
					this.manipulator.style.left = valInPercent + "%";

					this.bar.style.width = valInPercent + "%";

					this.component.setAttribute("data-val", this.val);
					this.currentSliderVal.innerHTML = Math.round(this.val);
				}
			)
		);

		this.formValContainer.addEventListener("change", e => {
			this.setPos(e.currentTarget.value);
		});
	}
}