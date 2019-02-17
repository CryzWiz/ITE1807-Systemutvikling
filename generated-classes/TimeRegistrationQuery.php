<?php

require_once(dirname(__DIR__, 1) . "/public_html/ITE1807/helper/TaskTimeRegUser.php");
use Base\TimeRegistrationQuery as BaseTimeRegistrationQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'timeregistration' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TimeRegistrationQuery extends BaseTimeRegistrationQuery
{

    public static function getTimeRegistrationByTaskId($taskId) : array {
        $task_regs = TimeRegistrationQuery::create()->findByTaskId($taskId);

        $ret =  array();
        foreach($task_regs as $task_reg){
            $tr = TaskTimeRegUser::create($task_reg);
            array_push($ret,$tr);
        }
        return $ret;
    }

}
