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
	constructor(component) {
		this.component = component;
		this.component.getInstance = () => this;
		this.heading = this.component.querySelector(".heading");
		this.body = this.component.querySelector(".body");
		this.btnApply = this.component.querySelector(".apply");
		this.btnCancel = this.component.querySelector(".cancel");
		this.btnClose = this.component.querySelector(".btn-popup-close");
		this.backBlur = this.component.querySelector(".popup-back-blur");

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
		this.setTexts("", "", _atxt("accept"), _atxt("cancel"));
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
		this.component.classList.add("show");
	}

	close() {
		this.component.classList.remove("show");
		this.resetCallbacks();

		setTimeout(() => {
			this.resetTexts();
			this.resetBtnsTypes();
		}, 150);
	}
}