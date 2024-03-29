class ImgUploader {
	constructor(component, maxNumberImgs, uploadAction) {
		this.component = component;
		this.initEvents();
		this.counter = this.component.querySelectorAll("[data-alias]").length;
		this.maxNumberImgs = maxNumberImgs;
		this.emptyTemplate = this.component.querySelector(".reference-selected-img .selected-img.empty").cloneNode(true);
		this.uploadAction = uploadAction;

		this.component.parentNode.getInstance = () => this;
	}

	initEvents() {
		this.component.querySelector(".add-img").addEventListener("click", e => {
			this.component.querySelector('input[name="imgs"]').click();
		});

		this.component.querySelector('input[name="imgs"]').addEventListener("change", e => {
			for(let file of e.currentTarget.files) {
				this.setFile(file);
			}

			e.currentTarget.value = "";
		});

		this.component.addEventListener("dragover", e => {
			e.preventDefault();
			for(let item of e.dataTransfer.items) {
				if(item.kind == "file" && item.type == "image/jpeg") {
					this.component.classList.add("drag-and-drop");
					break;
				}
			}
		});

		this.component.addEventListener("dragleave", e => {
			e.preventDefault();
			this.component.classList.remove("drag-and-drop");
		});

		this.component.addEventListener("drop", e => {
			e.preventDefault();
			this.component.classList.remove("drag-and-drop");
			
			for(let item of e.dataTransfer.items) {
				if(item.kind == "file"){
					this.setFile(item.getAsFile());
				}
			}
		});

		this.component.querySelectorAll(".selected-img").forEach(item => {
			if(!item.classList.contains(".empty")) {
				this.addEventsTo(item);
			}
		});
	}

	addEventsTo(imgContainer) {
		imgContainer.querySelector(".btn-remove").addEventListener("click", e => {
			e.preventDefault();
			e.currentTarget.parentNode.parentNode.remove();
			this.component.querySelector(".add-img").classList.remove("dnone");
			this.counter--;

			this.component.querySelector(".selected-imgs-grid").appendChild(this.emptyTemplate.cloneNode(true));
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
			this.component.querySelector(".add-img").classList.add("dnone");
			return true;
		}

		return false;
	}

	getPreparedData() {
		const data = [];
		this.component.querySelectorAll(".selected-img img[data-alias]").forEach(img => {
			data.push({
				"alias": img.getAttribute("data-alias"),
				"path": img.getAttribute("data-path"),
				"url": img.getAttribute("data-url")
			});
		});
		
		return data;
	}

	setFile(file) {
		if(file.type != "image/jpeg") {
			return false;
		}

		let reader = new FileReader();
		reader.readAsDataURL(file);

		reader.onload = () => {
			if(this.checkNumberImgsOnMax()) return false;

			const img = document.createElement('img');
			img.src = reader.result;
			const imgContainer = this.component.querySelector(".selected-imgs-grid .selected-img.empty");
			imgContainer.classList.remove("empty");
			imgContainer.appendChild(img);
			this.uploadImg(imgContainer, reader.result);

			this.counter++;
			if(this.checkNumberImgsOnMax()) return false;
		};

		reader.onerror = () => {
			// TODO: need output error for user to screen in browser
			console.error("Error of upload img");
		}
	}

	uploadImg(imgContainer, b64Img) {
		const data = new FormData();
		data.append("img", b64Img);
		const uploadBar = imgContainer.querySelector(".upload-progress-bar .bar");
		const img = imgContainer.querySelector("img");
		imgContainer.classList.add("load-process");

		const xhr = new XMLHttpRequest();
		xhr.open("POST", this.uploadAction);
		
		xhr.onload = () => {
			imgContainer.classList.remove("load-process");
			if(xhr.status == 200){
				const resp = JSON.parse(xhr.response);
				if(resp.status) {
					img.setAttribute("data-alias", resp.data.image.alias);
					img.setAttribute("data-path", resp.data.image.path);
					img.setAttribute("data-url", resp.data.image.url);
				} else {
					// TODO: show error message for user
				}
			} else {
				// TODO: show error message for user
			}
		}

		xhr.upload.onprogress = e => {	
			const percent = e.loaded / e.total * 100;
			uploadBar.style.width = percent + "%";
		};

		xhr.onerror = () => {
			// TODO: show error message for user
			console.error("Upload error");
		}

		xhr.send(data);
	}
}