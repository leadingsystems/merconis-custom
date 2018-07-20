<?php

namespace LeadingSystems\Api;

class ls_apiResourceControllerStandard extends \Controller {
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
	 * Loads a contao language file.
	 *
	 * Scope: FE and BE
	 *
	 * Allowed user types: apiUser, feUser, beUser
	 * 
	 * Parameters:
	 * >> var_name (mandatory): an array of language file names to load
	 * >> var_keys (mandatory): an array of keys defining the language values to actually return, using dot notation (e.g. TL_LANG.key1.key2)
	 * >> str_language (optional): the language code of the language to be loaded
	 * >> bln_noCache (optional): true/false to indicate whether or not to use the cache
	 */
	protected function apiResource_loadLanguageFiles() {
		$this->obj_apiReceiver->requireScope(['FE', 'BE']);
		$this->obj_apiReceiver->requireUser(['apiUser', 'feUser', 'beUser']);

		/*
		 * ==>
		 * Read and validate input parameters
		 */
		if (!$this->Input->get('var_name')) {
			$this->obj_apiReceiver->fail();
			$this->obj_apiReceiver->set_data('no language file name(s) given [var_name]', 'appendCommaSeparated');
		} else {
			$arr_names = is_array($this->Input->get('var_name')) ? $this->Input->get('var_name') : array($this->Input->get('var_name'));
		}
		
		if (!$this->Input->get('var_keys')) {
			$this->obj_apiReceiver->fail();
			$this->obj_apiReceiver->set_data('no language array key(s) given [var_keys]', 'appendCommaSeparated');
		} else {
			$arr_keys = is_array($this->Input->get('var_keys')) ? $this->Input->get('var_keys') : array($this->Input->get('var_keys'));
		}
		
		$str_language = $this->Input->get('str_language') ?: null;
		
		$bln_noCache = $this->Input->get('bln_noCache') ?: false;
		
		if ($this->obj_apiReceiver->check_hasError() || $this->obj_apiReceiver->check_isFailed()) {
			return;
		}
		/*
		 * <==
		 */
		
		/*
		 * Load the required language files
		 */
		if (isset($arr_names) && is_array($arr_names)) {
			foreach ($arr_names as $str_name) {
				$this->loadLanguageFile($str_name, $str_language, $bln_noCache);
			}
		}
		
		/*
		 * Get the requested language values identified by the given keys
		 */
		$arr_languageValues = array();

		if (isset($arr_keys) && is_array($arr_keys)) {
			foreach ($arr_keys as $str_key) {
				$var_tmpRef = &$arr_languageValues;

				$arr_keyParts = explode('.', $str_key);
				$int_numKeyParts = count($arr_keyParts);
				$var_currentlyAccessedLanguageValue = $GLOBALS['TL_LANG'];

				foreach ($arr_keyParts as $int_i => $str_keyPart) {
					if ($str_keyPart === 'TL_LANG') {
						continue;
					}

					$var_currentlyAccessedLanguageValue = $var_currentlyAccessedLanguageValue[$str_keyPart];

					if (!key_exists($str_keyPart, $var_tmpRef)) {
						$var_tmpRef[$str_keyPart] = $int_i < ($int_numKeyParts - 1) ? array() : $var_currentlyAccessedLanguageValue;
					}
					$var_tmpRef = &$var_tmpRef[$str_keyPart];
				}
			}
		}
		
		$this->obj_apiReceiver->success();
		$this->obj_apiReceiver->set_data($arr_languageValues);
	}
}
