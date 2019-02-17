<?php

use Base\WorkStatus as BaseWorkStatus;

/**
 * Skeleton subclass for representing a row from the 'work_status' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class WorkStatus extends BaseWorkStatus
{
    public static function getAll(){

        return WorkStatusQuery::create()->find();
    }

    public static function getAllAsArray(){

        $ret =  array();
        foreach( WorkStatus::getAll() as $s){
            $ret[$s->getId()]= $s->getStatus();
        }

        return $ret;
    }
}



