class Lib {
	constructor() {

		this.collapse = function() {	
			this.init = () => {
				document.querySelectorAll("[data-collapse-toggle]").forEach( 
					item => item.addEventListener("click", e => {
						lib.collapse().toggle( e.currentTarget.getAttribute("data-collapse-toggle") );
					})
				);

				document.querySelectorAll("[data-collapse-show]").forEach( 
					item => item.addEventListener("click", e => {
						lib.collapse().show( e.currentTarget.getAttribute("data-collapse-show") );
					})
				);

				document.querySelectorAll("[data-collapse-hide]").forEach( 
					item => item.addEventListener("click", e => {
						lib.collapse().hide( e.currentTarget.getAttribute("data-collapse-hide") );
					})
				);
			}

			this.show = (selector) => {
				const el = document.querySelector(selector);
				if (el.classList.contains("collapsing") || el.classList.contains("collapse-show")) {
					return;
				}
				el.classList.remove("collapse");
				const height = el.offsetHeight;
				el.style.height = 0;
				el.style.overflow = "hidden";
				el.style.transition = `height 150ms linear`;
				el.classList.add("collapsing");
				el.offsetHeight;
				el.style.height = `${height}px`;
				window.setTimeout(() => {
					el.classList.remove("collapsing");
					el.classList.add("collapse");
					el.classList.add("collapse-show");
					el.style.height = "";
					el.style.transition = "";
					el.style.overflow = "";
				}, 150);
			}

			this.hide = (selector) => {
				const el = document.querySelector(selector);
				if (el.classList.contains("collapsing") || !el.classList.contains("collapse-show")) {
					return;
				}
				el.style.height = `${el.offsetHeight}px`;
				el.offsetHeight;
				el.style.height = 0;
				el.style.overflow = "hidden";
				el.style.transition = `height 150ms linear`;
				el.classList.remove("collapse");
				el.classList.remove("collapse-show");
				el.classList.add("collapsing");

				window.setTimeout(() => {
					el.classList.remove("collapsing");
					el.classList.add("collapse");
					el.style.height = "";
					el.style.transition = "";
					el.style.overflow = "";
				}, 150);
			}

			this.toggle = (selector) => {
				document.querySelector(selector).classList.contains("collapse-show") 
					? this.hide(selector) 
					: this.show(selector);
			}

			return this;
		}
	}
}

window.lib = new Lib();