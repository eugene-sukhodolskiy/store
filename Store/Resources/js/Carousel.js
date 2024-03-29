class Carousel {
	constructor(component) {
		this.component = component;
		this.imgsContainer = this.component.querySelector(".imgs-container");
		this.imgs = this.imgsContainer.querySelectorAll(".img-item");
		this.prevBtns = this.component.querySelectorAll(`[data-carousel-control="prev"]`);
		this.nextBtns = this.component.querySelectorAll(`[data-carousel-control="next"]`);
		this.imgPreviewsContainer = this.component.querySelector(".img-previews");
		this.previews = this.imgPreviewsContainer.querySelectorAll(".img-preview-item");
		this.imgViewer = this.component.querySelector(".carousel-img-view");
		this.imgViewerCloseBtn = this.imgViewer.querySelector(".btn-popup-close");
		this.imgViewObject = this.imgViewer.querySelector(".view");
		this.controlPanel = this.component.querySelector(".carousel-control");
		this.imgViewerPreloader = this.imgViewer.querySelector(".preloader-wrap");
		this.imgViewerPreloaderComponent = new Preloader(this.imgViewerPreloader.querySelector(".component.preloader"));
		this.renderFieldPreloader = this.component.querySelector(".render-field .preloader-wrap");
		this.renderFieldPreloaderComponent = new Preloader(this.renderFieldPreloader.querySelector(".component.preloader"));

		this.component.getInstance = () => this; 
		this.viewerMode = false;
		this.initEvents();

		this.total = this.imgs.length;
		this.currentNum = 0;

		this.update();
	}

	initEvents() {
		this.prevBtns.forEach(
			item => item.addEventListener("click", e => this.prevImg())
		);

		this.nextBtns.forEach(
			item => item.addEventListener("click", e => this.nextImg())
		);

		this.previews.forEach(
			item => item.addEventListener("click", e => this.goToImg(e.currentTarget.getAttribute("data-carousel-control-goto")))
		);

		this.imgs.forEach(
			item => item.querySelector("img").addEventListener("click", e => {
				this.view(e.currentTarget.getAttribute("data-carousel-control-view"))
			})
		);

		this.imgs.forEach(
			item => item.querySelector("img").addEventListener("load", e => {
				if(!e.currentTarget.getAttribute("data-lazy-load")){
					this.renderFieldPreloaderComponent.hide();
				}
			})
		);

		this.imgViewerCloseBtn.addEventListener("click", e => this.closeView());

		this.imgViewObject.addEventListener("load", e => {
			e.currentTarget.classList.remove("hide");
			this.imgViewerPreloaderComponent.hide();
		});

		this.keyboardEvents();
	}

	keyboardEvents() {
		window.addEventListener("keyup", e => {
			if(this.isFullScreenView()) {
				if(e.keyCode == 27) {
					this.closeView();
				}
			}

			if(e.keyCode == 37) {
				this.prevImg();
			}else if(e.keyCode == 39) {
				this.nextImg();
			}
		});
	}

	prevImg() {
		this.currentNum--;
		if(this.currentNum < 0) {
			this.currentNum = 0;
		}else {
			this.update();
		}
	}

	nextImg() {
		this.currentNum++;
		if(this.currentNum > this.total - 1) {
			this.currentNum = this.total - 1;
		} else {
			this.update();
		}
	}

	update() {
		this.imgsContainer.style.marginLeft = `-${this.currentNum}00%`;
		if(this.currentNum <= 0) {
			this.prevBtns.forEach(item => item.classList.add("disable"));
		} else {
			this.prevBtns.forEach(item => item.classList.remove("disable"));
		}

		if(this.currentNum >= this.total - 1) {
			this.nextBtns.forEach(item => item.classList.add("disable"));
		} else {
			this.nextBtns.forEach(item => item.classList.remove("disable"));
		}

		this.updatePreviews();

		this.lazyLoad(this.imgs[this.currentNum].querySelector("img"));

		if(this.viewerMode) {
			this.imgViewerPreloaderComponent.show();
			this.imgViewObject.classList.add("hide");
			this.imgViewObject.src = this.imgs[this.currentNum].querySelector("img").getAttribute("data-carousel-control-view");
		}
	}

	updatePreviews() {
		this.previews.forEach(item => item.classList.remove("active"));
		this.previews[this.currentNum].classList.add("active");

		const offsetLeft = this.previews[this.currentNum].offsetLeft;
		const visibilitySilhoette = offsetLeft + this.previews[this.currentNum].clientWidth;
		const previewsContainerWidth = this.imgPreviewsContainer.clientWidth;
		this.imgPreviewsContainer.scrollTo({
			"left": offsetLeft - 50,
			"behavior": "smooth"
		});
	}

	lazyLoad(img) {
		const largeImgUrl = img.getAttribute("data-lazy-load");
		if(largeImgUrl){
			this.renderFieldPreloaderComponent.show();
			img.src = largeImgUrl;
			img.removeAttribute("data-lazy-load");
		}
	}

	goToImg(num) {
		if(num == this.currentNum) {
			return;
		}

		if(num >= 0 && num <= this.total - 1) {
			this.currentNum = num;
			this.update();
		}
	}

	view(url) {
		this.viewerMode = true;
		this.imgViewerPreloaderComponent.show();
		this.imgViewObject.src = url;
		this.imgViewObject.classList.add("hide");
		this.imgViewer.classList.add("show");
		setTimeout(() => {
			this.controlPanel.classList.add("viewer-mode");
		}, 150);
	}

	closeView() {
		this.viewerMode = false;
		this.imgViewerPreloaderComponent.hide();
		this.imgViewer.classList.remove("show");
		this.controlPanel.classList.remove("viewer-mode");
	}

	isFullScreenView() {
		return this.viewerMode;
	}
}