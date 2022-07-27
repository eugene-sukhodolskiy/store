class App {
	constructor() {
		console.log("App Start");

		this.auth = new Auth();
		this.initBaseEvents();
	}

	initBaseEvents() {
		$(".btn-nav-on-mob-show").on("click", e => {
			const $this = $(e.currentTarget);
			if($this.hasClass("active")) {
				$this.removeClass("active");
				$(".navigation-main-wrapper, .userbar-wrapper").removeClass("show");
			}else{
				$this.addClass("active");
				$(".navigation-main-wrapper, .userbar-wrapper").addClass("show");
			}
		});
	}
}

$(document).ready(function(){
	window.app = new App();
});