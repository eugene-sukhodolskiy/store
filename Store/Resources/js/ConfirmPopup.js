/**
  confirmPopup.show({
		heading: "Popup heading",
		body: "Body text",
		applyBtnText: "Apply text on btn",
		applyBtnType: "success",
		cancelBtnText: "Cancel text on btn",
		cancelBtnType: "warning",
		applyCallback: () => { console.log(`Apply`) },
		cancelCallback: () => { console.log(`Cancel`) },
		closeCallback: () => { console.log(`Close`) }
	})
 */

class ConfirmPopup {
	constructor(selector) {
		this.container = document.querySelector(selector);
		this.container.getInstance = () => this;
		this.heading = this.container.querySelector(".heading");
		this.body = this.container.querySelector(".body");
		this.btnApply = this.container.querySelector(".apply");
		this.btnCancel = this.container.querySelector(".cancel");
		this.btnClose = this.container.querySelector(".btn-popup-close");
		this.backBlur = this.container.querySelector(".popup-back-blur");

		this.resetCallbacks();
		this.resetTexts();
		this.resetBtnsTypes();

		this.initEvents();
	}

	resetCallbacks() {
		this.applyCallback = () => {};
		this.cancelCallback = () => {};
		this.closeCallback = () => {};
	}

	resetTexts() {
		this.setTexts("", "", "Принять", "Отмена");
	}

	resetBtnsTypes() {
		this.btnApply.classList.remove("btn-warning", "btn-success", "btn-danger", "btn-default");
		this.btnCancel.classList.remove("btn-warning", "btn-success", "btn-danger", "btn-primary");
		this.btnApply.classList.add("btn-primary");
		this.btnCancel.classList.add("btn-default");
	}

	setTexts(heading, body, applyText, cancelText) {
		this.heading.innerHTML = heading;
		this.body.innerHTML = body || "";
		this.btnApply.innerHTML = applyText;
		this.btnCancel.innerHTML = cancelText;
	}

	setBtnsTypes(applyType, cancelType) {
		applyType = applyType || "primary";
		cancelType = cancelType || "default";

		this.btnApply.classList.remove("btn-primary");
		this.btnApply.classList.add(`btn-${applyType}`);
		this.btnCancel.classList.remove("btn-default");
		this.btnCancel.classList.add(`btn-${cancelType}`);
	}

	initEvents() {
		this.btnApply.addEventListener("click", e => {
			this.applyCallback();
			this.close();
		});

		this.btnCancel.addEventListener("click", e => {
			this.cancelCallback();
			this.close();
		});

		const closeBtnEvent = e => {
			this.closeCallback();
			this.close();
		}

		this.btnClose.addEventListener("click", closeBtnEvent);
		this.backBlur.addEventListener("click", closeBtnEvent);
	}

	show(params) {
		this.applyCallback = params.applyCallback;
		
		if(params.cancelCallback) {
			this.cancelCallback = params.cancelCallback;
		}

		if(params.closeCallback) {
			this.closeCallback = params.closeCallback;
		}

		this.setTexts(params.heading, params.body, params.applyBtnText, params.cancelBtnText);
		this.setBtnsTypes(params.applyBtnType, params.cancelBtnType);
		this.container.classList.add("show");
	}

	close() {
		this.container.classList.remove("show");
		this.resetCallbacks();

		setTimeout(() => {
			this.resetTexts();
			this.resetBtnsTypes();
		}, 150);
	}
}