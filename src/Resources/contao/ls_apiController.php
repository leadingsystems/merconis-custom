<?php

namespace LeadingSystems\Api;

class ls_apiController extends \Controller {
	protected $str_status = 'fail';
	protected $var_data = null;
	protected $str_message = null;
	protected $str_code = null;
	
	/*
	 * Setting the status will also set the appropriate http response code.
	 * Until then we use 501 as the default because if no status will be set
	 * 501 (not implemented) seems to be the most appropriate code.
	 */
	protected $int_httpResponseCode = 501;

	protected $str_headerContentType = 'application/json';
	
	protected $bln_statusSet = false;
	
	protected $str_resourceMethodNamePrefix = 'apiResource_';
	
	protected $arr_pageData = null;
		
	public function set_data($var_data, $str_mode = 'overwrite') {
		switch ($str_mode) {
			case 'appendArray':
				/*
				 * Create an array from the current value if it isn't an array already
				 */
				if (!empty($this->var_data) && !is_array($this->var_data)) {
					$this->var_data = array($this->var_data);
				}
				
				$this->var_data[] = $var_data;
				break;
			
			case 'appendCommaSeparated':
				if (!empty($this->var_data) && $var_data) {
					$this->var_data .= ', ';
				}
				
				$this->var_data .= $var_data;
				break;
			
			case 'overwrite':
			default:
				$this->var_data = $var_data;
				break;
		}
	}
	
	public function set_message($str_message, $str_mode = 'overwrite') {
		if ($this->str_status !== 'error') {
			throw new \Exception('property "message" not allowed for status "'.$this->str_status.'". Only status "error" can use this property.');
		}
		
		switch ($str_mode) {
			case 'appendCommaSeparated':
				if (!empty($this->str_message) && $str_message) {
					$this->str_message .= ', ';
				}
				
				$this->str_message .= $str_message;
				break;
			
			case 'overwrite':
			default:
				$this->str_message = $str_message;
				break;
		}
	}
	
	public function set_code($str_code) {
		if ($this->str_status !== 'error') {
			throw new \Exception('property "code" not allowed for status "'.$this->str_status.'". Only status "error" can use this property.');
		}
		$this->str_code = $str_code;
	}
	
	public function set_httpResponseCode($int_httpResponseCode) {
		$this->int_httpResponseCode = $int_httpResponseCode;
	}
	
	public function set_headerContentType($str_contentType) {
		$this->str_headerContentType = $str_contentType;
	}

	public function success() {
		$this->str_status = 'success';
		$this->int_httpResponseCode = 200;
		$this->bln_statusSet = true;
	}
	
	public function check_isSucceeded() {
		return $this->bln_statusSet && $this->str_status === 'success';
	}
	
	public function fail() {
		$this->str_status = 'fail';
		$this->int_httpResponseCode = 400;
		$this->bln_statusSet = true;
	}
	
	public function check_isFailed() {
		return $this->bln_statusSet && $this->str_status === 'fail';
	}
	
	public function error() {
		$this->str_status = 'error';
		$this->int_httpResponseCode = 400;
		$this->bln_statusSet = true;
	}
	
	public function check_hasError() {
		return $this->bln_statusSet && $this->str_status === 'error';
	}
	
	public function run() {
		if (TL_MODE === 'FE') {
			/*
			 * ## Get page data which is later needed for url generation ->
			 */
			global $objPage;
			$this->import('Database');

			$obj_dbres_apiPage = $this->Database->prepare("
				SELECT	*
				FROM	tl_page
				WHERE	id = ?
			")
			->limit(1)
			->execute($objPage->id);

			if (!$obj_dbres_apiPage->numRows) {
				return;
			}

			$this->arr_pageData = $obj_dbres_apiPage->row();
			/*
			 * <- ##
			 */
		}

		$this->processRequest();
		
		$arr_jsend = array(
			'status' => $this->str_status,
			'data' => $this->var_data
		);
		
		if ($this->str_status === 'error') {
			$arr_jsend['message'] = $this->str_message;
			$arr_jsend['code'] = $this->str_code;
		}
		
		http_response_code($this->int_httpResponseCode);
		header('Content-Type: '.$this->str_headerContentType);

		/*
		 * If the content type used in the header tells us that we don't do
		 * a json output, we simply echo the data and then exit
		 */
		if (stripos($this->str_headerContentType, 'json') === false && $this->str_status !== 'error') {
			echo $arr_jsend['data'];
			exit;
		}
		
		$json_return = json_encode($arr_jsend);
		
		if ($json_return === false) {
			$arr_jsend = array(
				'status' => 'error',
				'message' => 'return value could not be json encoded'
			);
			$json_return = json_encode($arr_jsend);
		}
		
		echo $json_return;
		exit;
	}

	public function requireUser($arr_requiredUserTypes = ['apiUser']) {
		if (!ls_api_authHelper::authenticate($arr_requiredUserTypes)) {
			throw new \Exception('Access denied');
		}
	}

	public function requireScope($arr_requiredScopes = ['FE', 'BE']) {
		if (!in_array(TL_MODE, $arr_requiredScopes)) {
			throw new \Exception('Scope not allowed: '.TL_MODE);
		}
	}

	protected function processRequest() {
		/*
		 * Identify the requested resource
		 */
		$str_resourceName = $this->Input->get('resource');
		if (!$str_resourceName) {
			/*
			$this->error();
			$this->message = 'no resource identifier given';
			 * 
			 */
			$this->returnApiDescription();
			return;
		}
		
		/*
		 * In the api controller class actually providing the resource method,
		 * the resource methods are named "apiResource_someName" due to reflection
		 * reasons (auto documentation of the api resources), whereas the
		 * api request only calls the resource by "someName". Therefore we add
		 * the "apiResource_" prefix to the resource name before passing it
		 * as an argument when calling the api controller's processRequest method.
		 */
		$str_resourceName = $this->str_resourceMethodNamePrefix.$str_resourceName;
		
		try {
			if (isset($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest']) && is_array($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'])) {
				foreach ($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'] as $ls_api_hookCallback) {
					$objMccb = \System::importStatic($ls_api_hookCallback[0]);
					$objMccb->{$ls_api_hookCallback[1]}($str_resourceName, $this);

					/*
					 * If one hooked callback function reacted on the given resource
					 * name, in which case it must have set a status, we skip all
					 * other hooked functions because we don't want multiple actions
					 * to be performed.
					 */
					if ($this->bln_statusSet) {
						break;
					}
				}
			}
		} catch (\Exception $e) {
			$this->error();
			$this->set_message($e->getMessage());
			$this->set_code($e->getCode());
		}
	}
	
	/*
	 * Walk through all methods of all hooked classes, grab those with a prefixed
	 * name, collect some information and return it as some kind of automatically
	 * generated api documentation
	 */
	protected function returnApiDescription() {
		$arr_resources = array();

		if (isset($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest']) && is_array($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'])) {
			foreach ($GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'] as $ls_api_hookCallback) {
				$obj_reflection = new \ReflectionClass($ls_api_hookCallback[0]);
				$arr_reflectionMethods = $obj_reflection->getMethods();
				
				if (is_array($arr_reflectionMethods)) {
					foreach ($arr_reflectionMethods as $obj_reflectionMethod) {
						/*
						 * Skip methods with unprefixed names
						 */
						if (strpos($obj_reflectionMethod->name, $this->str_resourceMethodNamePrefix) === false) {
							continue;
						}
						
						$arr_resourceDetails = array();
						$arr_resourceDetails['name'] = $this->getResourceName($obj_reflectionMethod);
						$arr_resourceDetails['url'] = $this->getResourceUrl($obj_reflectionMethod, $arr_resourceDetails['name']);
						$arr_resourceDetails['description'] = $this->getResourceDescription($obj_reflectionMethod);
						
						$arr_resources[] = $arr_resourceDetails;
					}
				}
			}
		}
		
		$this->success();
		$this->set_data(
			array(
				'resources' => $arr_resources
			)
		);
	}
	
	protected function getResourceName($obj_reflectionMethod) {
		$str_resourceName = '';
		
		if (!is_object($obj_reflectionMethod)) {
			return $str_resourceName;
		}
		
		$str_resourceName = substr($obj_reflectionMethod->name, strlen($this->str_resourceMethodNamePrefix));
		
		return $str_resourceName;
	}
	
	protected function getResourceUrl($obj_reflectionMethod, $str_resourceName) {
		$str_resourceUrl = '';
		
		if (!is_object($obj_reflectionMethod)) {
			return $str_resourceUrl;
		}
		
		if (TL_MODE === 'FE') {
			/*
			 * Disabling the registered generateFrontendUrl hooks to make sure that registered hooks
			 * can not produce an error.
			 */
			$arr_tmp_generateFrontendUrlHooks = $GLOBALS['TL_HOOKS']['generateFrontendUrl'];
			$GLOBALS['TL_HOOKS']['generateFrontendUrl'] = array();

			$str_resourceUrl = $this->generateFrontendUrl($this->arr_pageData, '/resource/'.$str_resourceName);
			$str_resourceUrl = $this->Environment->base.$str_resourceUrl;

			$GLOBALS['TL_HOOKS']['generateFrontendUrl'] = $arr_tmp_generateFrontendUrlHooks;
			unset($arr_tmp_generateFrontendUrlHooks);
		} else {
			$str_resourceUrl = $this->Environment->base.'contao/main.php?do=be_mod_ls_apiReceiver&resource='.$str_resourceName;
		}
		
		return $str_resourceUrl;
	}
	
	protected function getResourceDescription(\ReflectionMethod $obj_reflectionMethod) {
		$str_resourceDescription = '';
		
		if (!is_object($obj_reflectionMethod)) {
			return $str_resourceDescription;
		}
		
		$str_resourceDescription = $obj_reflectionMethod->getDocComment();

		// clean the comment
		$str_resourceDescription = preg_replace('/\s\s+/', '', $str_resourceDescription);
		$str_resourceDescription = preg_replace('/\*/', '', $str_resourceDescription);
		$str_resourceDescription = substr($str_resourceDescription, 1);
		$str_resourceDescription = substr($str_resourceDescription, 0, -1);
		$str_resourceDescription = trim($str_resourceDescription);
		
		return $str_resourceDescription;
	}
}