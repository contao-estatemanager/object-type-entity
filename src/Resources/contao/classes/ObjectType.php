<?php

/**
 * This file is part of Oveleon Region Entity.
 *
 * (c) https://www.oveleon.de/
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */

namespace ContaoEstateManager\ObjectTypeEntity;

class ObjectType extends \Backend
{

    /**
     * Save connection from save callback
     *
     * @param $varValue
     * @param \DataContainer $dc
     *
     * @return string
     */
    public function objectTypeConnectionSaveCallback($varValue, \DataContainer $dc)
    {
        $arrObjectTypes = \StringUtil::deserialize($varValue);

        // delete previous connections
        ObjectTypeConnectionModel::deleteByPidAndPtable($dc->activeRecord->id, $dc->table);

        if($arrObjectTypes !== null)
        {
            foreach ($arrObjectTypes as $objectTypeId)
            {
                $this->saveConnectionRecord($objectTypeId, $dc->activeRecord->id, $dc->table);
            }
        }

        return $varValue;
    }

    /**
     * Save connections
     *
     * @param $oid
     * @param $pid
     * @param $ptable
     */
    public function saveConnectionRecord($oid, $pid, $ptable)
    {
        $objConnection = new ObjectTypeConnectionModel();
        $objConnection->oid = $oid;
        $objConnection->pid = $pid;
        $objConnection->ptable = $ptable;

        $objConnection->save();
    }
}
