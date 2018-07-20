<?php

namespace LeadingSystems\Api;

class be_mod_ls_apiReceiver extends \BackendModule {
	public function compile() {
		/*
		 * Make sure that api call URIs are never stored as a referrer because otherwise
		 * Contao would create "back" links pointing to api call URIs.
		 */
		$session = $this->Session->getData();
		$_SERVER['REQUEST_URI'] = $session['referer']['current'];
		$this->Environment->requestUri = $_SERVER['REQUEST_URI'];

		$obj_apiController = new ls_apiController();
		$obj_apiController->run();
	}
}