<?php

namespace LeadingSystems\Api;

class ls_api_custom_regexp
{
	public function customRegexp($str_regexp, &$var_value, \Widget $obj_widget) {
		switch ($str_regexp) {
			case 'ls_api_key':
				/*
				 * If no API key is set yet, we don't have to check a password. We only make sure that the password
				 * entered now doesn't contain a colon character.
				 */
				if (!$GLOBALS['TL_CONFIG']['ls_api_key']) {
					if (!$this->check_passwordIsValid($var_value)) {
						$obj_widget->addError(sprintf($GLOBALS['TL_LANG']['MSC']['ls_api']['rgxpErrorMessages']['ls_api_key']['passwordInvalid'], $obj_widget->label));
						return false;
					}
				} else if ($var_value !== $GLOBALS['TL_CONFIG']['ls_api_key']) {
					list($str_oldPassword, $str_newPassword) = explode(':', $var_value);
					if (!$str_newPassword) {
						$obj_widget->addError($GLOBALS['TL_LANG']['MSC']['ls_api']['rgxpErrorMessages']['ls_api_key']['changePasswordSyntaxWrong']);
						return false;
					}

					$str_oldPasswordHash = substr($GLOBALS['TL_CONFIG']['ls_api_key'], 0, 10).substr($GLOBALS['TL_CONFIG']['ls_api_key'], 20, strlen($GLOBALS['TL_CONFIG']['ls_api_key']));
					if (!password_verify($str_oldPassword, $str_oldPasswordHash)) {
						$obj_widget->addError($GLOBALS['TL_LANG']['MSC']['ls_api']['rgxpErrorMessages']['ls_api_key']['oldPasswordDoesNotMatch']);
						return false;
					}

					if (!$this->check_passwordIsValid($str_newPassword)) {
						$obj_widget->addError(sprintf($GLOBALS['TL_LANG']['MSC']['ls_api']['rgxpErrorMessages']['ls_api_key']['passwordInvalid'], $obj_widget->label));
						return false;
					}
				}

				return true;
				break;
		}
		return false;
	}

	protected function check_passwordIsValid($str_password) {
		return (strlen($str_password) >= 10 && strpos($str_password, ':') === false);
	}
}