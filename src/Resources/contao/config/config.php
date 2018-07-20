<?php

namespace LeadingSystems\Api;

if (TL_MODE == 'BE') {
	$GLOBALS['TL_CSS'][] = 'bundles/leadingsystemsapi/be/css/style.css';
}

$GLOBALS['BE_MOD']['ls_api'] = array(
	'ls_api_key' => array(
		'tables' => array('tl_ls_api_key')
	),

	'ls_api_user' => array(
		'tables' => array('tl_ls_api_user')
	),

	'be_mod_ls_apiReceiver' => array(
		'callback' => 'LeadingSystems\Api\be_mod_ls_apiReceiver'
	)
);

$GLOBALS['FE_MOD']['ls_api'] = array(
	'ls_apiReceiver' => 'LeadingSystems\Api\mod_ls_apiReceiver'
);

$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('LeadingSystems\Api\ls_api_custom_regexp', 'customRegexp');

$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('LeadingSystems\Api\ls_api_authHelper', 'bypassRefererCheckWithValidApiKey');

$GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'][] = array('LeadingSystems\Api\ls_apiResourceControllerStandard', 'processRequest');

$GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'][] = array('LeadingSystems\Api\ls_apiResourceControllerStandardBackend', 'processRequest');

$GLOBALS['LS_API_HOOKS']['apiReceiver_processRequest'][] = array('LeadingSystems\Api\ls_apiResourceControllerStandardFrontend', 'processRequest');