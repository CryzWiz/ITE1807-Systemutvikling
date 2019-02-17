<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19.04.2017
 * Time: 01.33
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
class ProjectTasksFetcher {

    public static function fetchProjectTasks($project_id) {
        $projectTasks = TaskQuery::create()->findByProjectId($project_id);
        $projectTasksSorted = array();
        for($i = 0; $i < sizeof($projectTasks); $i++){
            $p_Name = $projectTasks[$i]->getName();
            $p_TeamName = TeamQuery::create()->findOneById($projectTasks[$i]->getTeamId())->getName();
            $p_Estimated =$projectTasks[$i]->getPlannedhours();
            $p_Start = $projectTasks[$i]->getStart()->format('Y-m-d');
            $p_End = $projectTasks[$i]->getEnd()->format('Y-m-d');
            $p_Status = WorkStatusQuery::create()->findOneById($projectTasks[$i]->getStatusId())->getStatus();
            array_push($projectTasksSorted, array('name'=>$p_Name,
                'teamname'=>$p_TeamName,
                'estimated'=>$p_Estimated,
                'start'=>$p_Start,
                'end'=>$p_End,
                'status'=>$p_Status
            ));
        }
        return $projectTasksSorted;
    }
}