class Slider {
	constructor(slider) {
		this.slider = slider;
		this.val = 0;
		this.startTrackMoving = false;

		this.min = parseInt(this.slider.getAttribute("data-min-val"));
		this.max = parseInt(this.slider.getAttribute("data-max-val"));
		this.start = this.slider.getAttribute("data-val");
		this.formValContainer = this.slider.querySelector(".form-value-container");

		this.bar = this.slider.querySelector(".bar");
		this.track = this.slider.querySelector(".track");
		this.manipulator = this.slider.querySelector(".manipulator");
		this.currentSliderVal = this.slider.querySelector(".current-slider-val");
		this.manipulatorWidth = this.manipulator.offsetWidth;

		this.bar.style.width = (this.start / (this.max - this.min) * 100) + "%";
		this.manipulator.style.left = (this.start / (this.max - this.min) * 100) + "%";

		this.initEvents();
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

					this.slider.setAttribute("data-val", this.val);
					this.currentSliderVal.innerHTML = Math.round(this.val);
				}
			)
		);
	}
}