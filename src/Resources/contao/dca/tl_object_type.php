<?php
/*
 * This file is part of Oveleon Object Type Entity.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_object_type'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'markAsCopy'                  => 'title',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'published' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
            'mode'                    => 2,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;sort,search,limit'
		),
        'label' => array
        (
            'fields'                  => array('title'),
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
            'edit' => array
            (
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset()"',
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_object_type', 'toggleIcon')
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
        'default'                     => '{title_legend},title;{publish_legend},published'
	),

    // Fields
	'fields' => array
	(
		'id' => array
		(
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'vid' => array
		(
            'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'tstamp' => array
        (
            'sorting'                 => true,
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'title' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_object_type']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_object_type']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        )
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class tl_object_type extends Contao\Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('Contao\BackendUser', 'User');
	}


    /**
     * Return the "toggle visibility" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon(array $row, ?string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if (Contao\Input::get('tid'))
        {
            $this->toggleVisibility(Contao\Input::get('tid'), (Contao\Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_object_type::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        if (!$this->User->hasAccess('objectTypes', 'alpty') || ($objObjectType = ContaoEstateManager\ObjectTypeEntity\ObjectTypeModel::findById($row['id'])) === null)
        {
            return Contao\Image::getHtml($icon) . ' ';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . Contao\StringUtil::specialchars($title) . '"' . $attributes . '>' . Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * Disable/enable a user group
     *
     * @param integer              $intId
     * @param boolean              $blnVisible
     * @param Contao\DataContainer $dc
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function toggleVisibility(int $intId, bool $blnVisible, Contao\DataContainer $dc=null): void
    {
        // Set the ID and action
        Contao\Input::setGet('id', $intId);
        Contao\Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (is_array($GLOBALS['TL_DCA']['tl_object_type']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_object_type']['config']['onload_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        // Check the field access
        if (!$this->User->hasAccess('tl_object_type::published', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish object type ID ' . $intId . '.');
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_object_type WHERE id=?")
                ->limit(1)
                ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new \Versions('tl_object_type', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_object_type']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_object_type']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_object_type SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        $objVersions->create();
    }
}
