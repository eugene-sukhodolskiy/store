class ImgUploader {
	constructor(selector, maxNumberImgs) {
		this.container = document.querySelector(selector);
		this.initEvents();
		this.counter = 0;
		this.maxNumberImgs = maxNumberImgs;
		this.emptyTemplate = this.container.querySelector(".selected-img.empty").cloneNode(true);

		this.container.getPreparedData = () => this.getPreparedData();
	}

	initEvents() {
		this.container.querySelector(".add-img").addEventListener("click", e => {
			this.container.querySelector('input[name="imgs"]').click();
		});

		this.container.querySelector('input[name="imgs"]').addEventListener("change", e => {
			for(let file of e.currentTarget.files) {
				let reader = new FileReader();
				reader.readAsDataURL(file);

				reader.onload = () => {
					this.checkNumberImgsOnMax();

					const img = document.createElement('img');
					img.src = reader.result;
					const imgContainer = this.container.querySelector(".selected-imgs-grid .selected-img.empty");
					imgContainer.classList.remove("empty");
					imgContainer.appendChild(img);
					this.addEventsTo(imgContainer);

					this.counter++;
					this.checkNumberImgsOnMax();
			  };

			  reader.onerror = () => {
			  	// TODO: need output error for user to screen in browser
			  	console.error("Error of upload img");
			  }
			}

			e.currentTarget.value = "";
		});
	}

	addEventsTo(imgContainer) {
		imgContainer.querySelector(".btn-remove").addEventListener("click", e => {
			e.preventDefault();
			e.currentTarget.parentNode.parentNode.remove();
			this.container.querySelector(".add-img").classList.remove("dnone");
			this.counter--;

			this.container.querySelector(".selected-imgs-grid").appendChild(this.emptyTemplate.cloneNode(true));
		});

		imgContainer.querySelector(".btn-move-left").addEventListener("click", e => {
			e.preventDefault();
			const prevImg = e.currentTarget.parentNode.parentNode.previousElementSibling.querySelector("img");
			const thisImg = e.currentTarget.parentNode.parentNode.querySelector("img");
			thisImg.parentNode.appendChild(prevImg.cloneNode());
			prevImg.parentNode.appendChild(thisImg.cloneNode());
			prevImg.remove();
			thisImg.remove();
		});
	}

	checkNumberImgsOnMax() {
		if(this.counter >= this.maxNumberImgs) {
			return this.container.querySelector(".add-img").classList.add("dnone");
		}
	}

	getPreparedData() {
		return this;
	}
}