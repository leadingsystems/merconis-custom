<?php

namespace LeadingSystems\Api;

class ls_apiResourceControllerStandardBackend extends \Controller {
	protected static $objInstance;

	/** @var ls_apiController $obj_apiReceiver */
	protected $obj_apiReceiver = null;

	protected function __construct() {
		parent::__construct();
	}

	final private function __clone() {}

	public static function getInstance() {
		if (!is_object(self::$objInstance))
		{
			self::$objInstance = new self();
		}
		
		return self::$objInstance;
	}
	
	public function processRequest($str_resourceName, $obj_apiReceiver) {
		if (!$str_resourceName || !$obj_apiReceiver) {
			return;
		}
		
		$this->obj_apiReceiver = $obj_apiReceiver;
		
		/*
		 * If this class has a method that matches the resource name, we call it.
		 * If not, we don't do anything because another class with a corresponding
		 * method might have a hook registered.
		 */
		if (method_exists($this, $str_resourceName)) {
			$this->{$str_resourceName}();
		}
	}
	
	/**
	 * Returns the currently logged in backend user's name
	 *
	 * Scope: BE
	 *
	 * Allowed user types: apiUser, beUser
	 *
	 */
	protected function apiResource_getCurrentBackendUserName() {
		$this->obj_apiReceiver->requireScope(['BE']);
		$this->obj_apiReceiver->requireUser(['apiUser', 'beUser']);

		$this->import('BackendUser');
		$this->obj_apiReceiver->success();
		$this->obj_apiReceiver->set_data($this->BackendUser->name);
	}
}
