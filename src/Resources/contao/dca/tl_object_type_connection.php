<?php
/*
 * This file is part of Oveleon Object Type Entity.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_object_type_connection'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'oid,pid,ptable' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
            'mode'                    => 2,
            'fields'                  => array('ptable'),
            'flag'                    => 1,
            'panelLayout'             => 'sort,search,limit'
		),
        'label' => array
        (
            'fields'                  => array('ptable'),
            'format'                  => '%s'
        ),
		'global_operations' => array
		(
			'all' => array
			(
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
		)
	),

	// Palettes
	'palettes' => array
	(
        'default'                     => '{title_legend},oid,pid,ptable'
	),

    // Fields
	'fields' => array
	(
		'id' => array
		(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'oid' => array
		(
            'label'                   => array('Object type ID'),
            'search'                  => true,
            'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'pid' => array
		(
            'label'                   => array('ID'),
            'search'                  => true,
            'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'ptable' => array
		(
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		)
	)
);
