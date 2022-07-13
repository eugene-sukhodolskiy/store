class App {
	constructor() {
		console.log("App Start");

		this.auth = new Auth();
	}
}

$(document).ready(function(){
	window.app = new App();
});