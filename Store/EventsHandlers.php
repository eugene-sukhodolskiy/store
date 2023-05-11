<?php

namespace Store;

class EventsHandlers{
	public function handlers(){
		events() -> handler('kernel:Bootstrap.ready_app', function(Array $params){
			app() -> routes -> routes_init();
			if(!app() -> console_flag) {
				app() -> router -> start_routing();
			}
		});

		events() -> handler('kernel:CallControl.no_calls', function(Array $params){
			if(!app() -> console_flag) {
				echo "404 not found";
			}
		});

		if(FCONF["devmode"]) {
			events() -> handler("module:Template.start_making", function(Array $params){
				app() -> devtools -> add_template_to_map(
					$params["template_instance"],
					$params["template_name"]
				);
			});

			events() -> handler("kernel:Bootstrap.app_finished", function(Array $params){
				app() -> devtools -> show_template_map();
			});
		}
	}
}