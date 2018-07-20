<?php
namespace LeadingSystems\Api;

class ls_api_authHelper
{
	public static function authenticate($arr_allowedAuthTypes = ['apiUser'])
	{
		if (!self::checkApiKey()) {
			return false;
		}

		if (in_array('apiUser', $arr_allowedAuthTypes) && self::authenticateApiUser()) {
			return true;
		} else if (in_array('feUser', $arr_allowedAuthTypes) && self::authenticateFrontendUser()) {
			return true;
		} else if (TL_MODE === 'BE' && in_array('beUser', $arr_allowedAuthTypes) && self::authenticateBackendUser()) {
			return true;
		}

		return false;
	}

	protected static function authenticateFrontendUser()
	{
		if (FE_USER_LOGGED_IN) {
			return true;
		}

		return false;
	}

	protected static function authenticateBackendUser()
	{
		/*
		 * If this code is being executed, we have a backend call and
		 * a backend user must be logged in because otherwise we already
		 * would have been redirected to the backend login screen.
		 *
		 * Therefore, unless we actually check specific access rights
		 * to specific API resources we can simply return true here.
		 */
		return true;
	}

	protected static function authenticateApiUser()
	{
		$str_username = \Input::post('ls_api_username');
		$str_password = \Input::post('ls_api_password');

		if (!$str_username || !$str_password) {
			return false;
		}

		$obj_apiUser = \Database::getInstance()
			->prepare("
					SELECT		`password`
					FROM		`tl_ls_api_user`
					WHERE		`username` = ?
				")
			->limit(1)
			->execute(
				$str_username
			);

		if (!$obj_apiUser->numRows) {
			return false;
		}

		if (password_verify($str_password, $obj_apiUser->password)) {
			return true;
		}

		return false;
	}

	protected static function checkApiKey()
	{
		$str_apiKey = \Input::post('ls_api_key');
		if (!$str_apiKey) {
			$str_apiKey = \Input::get('ls_api_key');
		}

		if ($str_apiKey && $str_apiKey === self::getApiKey()) {
			return true;
		}

		return false;
	}

	/*
	 * In this function we check for a valid API key and if there is one,
	 * we deactivate the referer check. If there is none, we don't do anything.
	 */
	public static function bypassRefererCheckWithValidApiKey()
	{
		if (self::checkApiKey()) {
			\Config::set('disableRefererCheck', true);
		}
	}

	protected static function getApiKey()
	{
		return $GLOBALS['TL_CONFIG']['ls_api_key'];
	}
}