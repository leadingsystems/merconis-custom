<?php

namespace Merconis\Custom;

$GLOBALS['TL_DCA']['tl_merconis_custom_dummy'] = array(
	'config' => array(
		'dataContainer' => 'Table',
		'onload_callback' => array
		(
			array('Merconis\custom\tl_merconis_custom_dummy', 'checkPermission')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	
	'list' => array(
		'sorting' => array(
			'mode' => 1,
			'flag' => 1,
			'fields' => array('title'),
			'disableGrouping' => false,
			'panelLayout' => 'sort,search,limit'			
		),
		
		'label' => array(
			'fields' => array('title', 'description'),
			'format' => '<h2>%s</h2><p>%s</p>'
		),
		
		'global_operations' => array(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		
		'operations' => array(
			'edit' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'               => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		
		)	
	),
	
	'palettes' => array(
		'default' => '{title_legend},title;{description_legend},description;'
	),
	
	'fields' => array(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label' => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['title'],
			'exclude' => true,
			'search' => true,
			'sorting' => true,
			'flag' => 1,
			'inputType' => 'text',
			'eval' => array(
				'mandatory' => true,
				'maxlength' => 64,
				'tl_class'=>'w50'
			),
			'sql' => "varchar(64) COLLATE utf8_bin NULL"
		),

		'description' => array
		(
			'label' => &$GLOBALS['TL_LANG']['tl_merconis_custom_dummy']['description'],
			'exclude' => true,
			'inputType' => 'textarea',
			'sql' => "text NULL"
		)
	)
);

class tl_merconis_custom_dummy extends \Backend {
	public function __construct() {
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Check permissions to edit table tl_merconis_custom_dummy
	 *
	 * @throws \Contao\CoreBundle\Exception\AccessDeniedException
	 */
	public function checkPermission()
	{
		if (!$this->User->isAdmin)
		{
			throw new \Contao\CoreBundle\Exception\AccessDeniedException('Access restricted to administrators.');
		}
	}
}