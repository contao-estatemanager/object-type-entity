<?php

/**
 * This file is part of Oveleon Object Type Entity.
 *
 * (c) https://www.oveleon.de/
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

// Back end modules
$GLOBALS['BE_MOD']['content']['objectTypes'] = array
(
    'tables' => array('tl_object_type', 'tl_object_type_connection')
);

// Models
$GLOBALS['TL_MODELS']['tl_object_type'] = 'ContaoEstateManager\ObjectTypeEntity\ObjectTypeModel';
$GLOBALS['TL_MODELS']['tl_object_type_connection'] = 'ContaoEstateManager\ObjectTypeEntity\ObjectTypeConnectionModel';
