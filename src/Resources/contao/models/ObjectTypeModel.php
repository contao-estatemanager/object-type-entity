<?php

namespace ContaoEstateManager\ObjectTypeEntity;

use Contao\Model;

/**
 * Reads and writes object types
 *
 * @property integer $id
 * @property string  $vid
 * @property integer $tstamp
 * @property string  $title
 * @property boolean $published
 *
 * @method static ObjectTypeModel|null findById($id, array $opt=array())
 * @method static ObjectTypeModel|null findByPk($id, array $opt=array())
 * @method static ObjectTypeModel|null findOneBy($col, $val, array $opt=array())
 * @method static ObjectTypeModel|null findOneByTstamp($val, array $opt=array())
 * @method static ObjectTypeModel|null findOneByTitle($val, array $opt=array())
 * @method static ObjectTypeModel|null findOneByPublished($val, array $opt=array())
 *
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findByVid($val, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findByTstamp($val, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findByTitle($val, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findByPublished($val, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findMultipleByIds($var, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findBy($col, $val, array $opt=array())
 * @method static Model\Collection|ObjectTypeModel[]|ObjectTypeModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByPublished($val, array $opt=array())
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ObjectTypeModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_object_type';
}
