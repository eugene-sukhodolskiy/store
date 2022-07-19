class Alert {
	constructor(type, content, isClosable) {
		this.id = "alert-id-" + (new Date()).getTime() + Math.random();
		alertsList[this.id] = this;
		this.type = type;
		this.content = content;
		this.isClosable = isClosable || false;

		this.template = $(`.component.alert[data-id="alert-id-reference"]:eq(0)`).clone();
		this.initComponent();
	}

	initComponent() {
		this.template.addClass(`alert-${this.type}`);
		this.template.attr("data-id", this.id);
		this.template.find(".content").html(this.content);

		this.template.find(".close-alert").on("click", e => {
			e.preventDefault();
			this.close();
		});
	}

	showIn(container) {
		$(container).append(this.template);
		setTimeout(() => {
			this.template.addClass("show");
		}, 10);
	}

	close() {
		this.template.removeClass("show");
		setTimeout(() => {
			this.template.remove();
			delete alertsList[this.id];
		}, 250);
	}

	changeContent(newContent) {
		this.template.find(".content").html(newContent);
	}
}

const closeAlertComponent = alertId => {
	return alertsList[alertId].close();
}

const createAlertComponent = (type, content, isClosable) => {
	return new Alert(type, content, isClosable);
}

$(document).ready(() => {
	$(`.component.alert .close-alert`).on("click", e => {
		e.preventDefault();
		const alertId = $(e.currentTarget).attr("data-close-alert-id");
		closeAlertComponent(alertId);
	});
});

const alertsList = {};