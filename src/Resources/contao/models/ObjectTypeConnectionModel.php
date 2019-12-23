<?php

namespace ContaoEstateManager\ObjectTypeEntity;

/**
 * Reads and writes object type connections
 *
 * @property integer $oid
 * @property integer $pid
 * @property integer $ptable
 *
 * @method static ObjectTypeConnectionModel|null findOneByOid($id, array $opt=array())
 * @method static ObjectTypeConnectionModel|null findOneByPid($id, array $opt=array())
 * @method static ObjectTypeConnectionModel|null findOneByPtable($id, array $opt=array())
 *
 * @method static \Model\Collection|ObjectTypeConnectionModel[]|ObjectTypeConnectionModel|null findByOid($val, array $opt=array())
 * @method static \Model\Collection|ObjectTypeConnectionModel[]|ObjectTypeConnectionModel|null findByPid($val, array $opt=array())
 * @method static \Model\Collection|ObjectTypeConnectionModel[]|ObjectTypeConnectionModel|null findByPtable($val, array $opt=array())
 *
 * @method static integer countByOid($id, array $opt=array())
 * @method static integer countByPid($val, array $opt=array())
 * @method static integer countByPtable($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ObjectTypeConnectionModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_object_type_connection';
}
