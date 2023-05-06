class Utils {
	constructor() {
		this.stockAnimationDuration = 150;
	}

	slideUp(element, animationDuration) {
		animationDuration = animationDuration || this.stockAnimationDuration;
		element.style.overflow = "hidden";
		const height = element.scrollHeight;
		const perFrame = height / (animationDuration / 16); // 16ms = 1 frame
		let currentHeight = height;
		const animation = setInterval(function() {
			if (currentHeight - perFrame > 0) {
				currentHeight -= perFrame;
				element.style.height = currentHeight + "px";
			} else {
				clearInterval(animation);
				element.style.height = "0";
				element.style.display = "none";
			}
		}, 16);
	}

	slideDown(element, animationDuration) {
		animationDuration = animationDuration || this.stockAnimationDuration;
		element.style.height = 0;
		element.style.overflow = "hidden";
		element.style.display = "block";
		const height = element.scrollHeight;
		const perFrame = height / (animationDuration / 16); // 16ms = 1 frame
		let currentHeight = 0;
		const animation = setInterval(function() {
			if (currentHeight + perFrame < height) {
				currentHeight += perFrame;
				element.style.height = currentHeight + "px";
			} else {
				clearInterval(animation);
				element.style.height = height + "px";
			}
		}, 16);
	}
}

const utils = new Utils();