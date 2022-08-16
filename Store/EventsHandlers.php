<?php

namespace Store;

class EventsHandlers{
	public function handlers(){
		events() -> handler('kernel:Bootstrap.ready_app', function($params){
			app() -> routes -> routes_init();
			if(!app() -> console_flag) {
				app() -> router -> start_routing();
			}
		});

		events() -> handler('kernel:CallControl.no_calls', function($p){
			if(!app() -> console_flag) {
				echo "404 not found";
			}
		});
	}
}