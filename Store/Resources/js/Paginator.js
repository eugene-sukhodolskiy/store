class Paginator {
	constructor(component) {
		this.component = component;
		this.id = this.component.id;

		this.inp = this.component.querySelector(".page-num-selector");

		this.inp.addEventListener("keyup", e => {
			let val = Math.floor(e.currentTarget.value);
			const min = parseInt(e.currentTarget.getAttribute("min"));
			const max = parseInt(e.currentTarget.getAttribute("max"));

			if(e.keyCode == 13) {
				if(val < min) {
					val = min;
				}

				if(val > max) {
					val = max;
				}

				e.currentTarget.value = val;
				const url = e.currentTarget.getAttribute("data-current-url");
				document.location = (url.indexOf("?") == -1) ? url + `?pn=${val}` : url + `&pn=${val}`;
			}
		});

		this.inp.addEventListener("change", e => {
			let val = Math.floor(e.currentTarget.value);
			const min = parseInt(e.currentTarget.getAttribute("min"));
			const max = parseInt(e.currentTarget.getAttribute("max"));

			if(val < min) {
				val = min;
			}

			if(val > max) {
				val = max;
			}

			e.currentTarget.value = val;
		});
	}
}