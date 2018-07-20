<?php

namespace LeadingSystems\Api;

$GLOBALS['TL_DCA']['tl_ls_api_key'] = array(
	'config' => array(
		'dataContainer' => 'File',
		'closed' => true,
		'onsubmit_callback' => array(
			array('LeadingSystems\Api\tl_ls_api_key', 'removeApiKeyEntryFromLog')
		)
	),

	'palettes' => array(
		'default' => 'ls_api_key'
	),

	'fields' => array(
		'ls_api_key' => array(
			'exclude' => true,
			'label' => &$GLOBALS['TL_LANG']['tl_ls_api_key']['ls_api_key'],
			'inputType' => 'text',
			'eval' => array('tl_class' => 'clr', 'rgxp' => 'ls_api_key', 'autocomplete' => 'off'),
			'save_callback' => array(
				array('LeadingSystems\Api\tl_ls_api_key', 'createApiKey')
			)
		)
	)
);

class tl_ls_api_key extends \Backend
{
	public function __construct()
	{
		parent::__construct();
	}

	public function createApiKey($str_value)
	{
		if (!$str_value) {
			return '';
		}

		if (!$GLOBALS['TL_CONFIG']['ls_api_key']) {
			/*
			 * If no API key has previously been set, we create a new one now based on the currently given password
			 */
			$str_value = password_hash($str_value, PASSWORD_BCRYPT);
			$str_value = substr($str_value, 0, 10) . time() . substr($str_value, 10, strlen($str_value));
			return $str_value;
		} else {
			/*
			 * If an API key is already stored, we either do nothing or we create and set a new API key
			 */
			if (
				!$str_value
				|| $str_value === $GLOBALS['TL_CONFIG']['ls_api_key']
			) {
				/*
				 * If the value currently entered in the field is either the same as the stored value or it is empty,
				 * we simply keep the current API key.
				 */
				return $GLOBALS['TL_CONFIG']['ls_api_key'];
			} else {
				/*
				 * If the value currently entered requests a new API key, we extract the original ut from the
				 * previous API key and use it together with the new password to create the new API key.
				 */
				$ut_originalApiKey = substr($GLOBALS['TL_CONFIG']['ls_api_key'], 10, 10);
				list(, $str_newPassword) = explode(':', $str_value);

				$str_value = password_hash($str_newPassword, PASSWORD_BCRYPT);
				$str_value = substr($str_value, 0, 10) . $ut_originalApiKey . substr($str_value, 10, strlen($str_value));
				return $str_value;
			}
		}
	}

	public function removeApiKeyEntryFromLog() {
		\Database::getInstance()
			->prepare("
				DELETE FROM		`tl_log`
				WHERE			`text` LIKE '%ls_api_key%'
			")
			->execute();
	}
}
