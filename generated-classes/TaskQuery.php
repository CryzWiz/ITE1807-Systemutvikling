<?php
require_once(dirname(__DIR__, 1) . "/public_html/ITE1807/helper/TaskDTO.class.php");
use Base\TaskQuery as BaseTaskQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'task' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TaskQuery extends BaseTaskQuery
{
    /**
     * Find projects for specified team id.
     *
     * @return array with each element is TaskDTO
     */
    public static function getTasksDTOByProjectId(int $id) : array {
        $ret =  array();
        //$projects = ProjectQuery::create()->joinWithTeamProject()->findById($id);
        $tasks = TaskQuery::create()->findByProjectId($id);
        //findByProjectId($id)
        foreach( $tasks as $task){
            $t = TaskDTO::create($task);
            array_push($ret, $t);
        }

        return $ret;
    }
}
