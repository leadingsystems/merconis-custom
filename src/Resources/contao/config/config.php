<?php

namespace Merconis\Custom;

if (TL_MODE == 'BE') {
	$GLOBALS['TL_CSS'][] = 'bundles/leadingsystemsmerconiscustom/be/css/style.css';
}

$GLOBALS['BE_MOD']['merconis_custom'] = array(
	'merconis_custom_dummy' => array(
		'tables' => array('tl_merconis_custom_dummy')
	)
);

$GLOBALS['FE_MOD']['merconis_custom'] = array(
	'mod_merconis_custom_dummy' => 'Merconis\Custom\mod_merconis_custom_dummy'
);