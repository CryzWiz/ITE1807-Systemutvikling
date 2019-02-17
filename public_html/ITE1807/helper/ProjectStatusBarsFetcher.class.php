<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19.04.2017
 * Time: 01.33
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");

class ProjectStatusbarsFetcher {

    public static function getAllEstimatedHours($projectID){
        $estimatedHours = 0;
        $temp = TaskQuery::create()->findByProjectId($projectID);
        foreach($temp as $h ){
            $temp = $h->getPlannedhours();
            $estimatedHours = $estimatedHours + $h->getPlannedhours();
        }
        return $estimatedHours;
    }

    public static function getTotalRegisteredHours($projectID){
        $registeredHours = 0;

        $tasksOnProject = self::getAllTasksOnProject($projectID);

        foreach($tasksOnProject as $task){
            $temp_hourReg = TimeRegistrationQuery::create()->findByTaskId($task->getId());
            foreach ($temp_hourReg as $hour){
                if($hour != null){
                    $startDate = $hour->getStart();
                    $stopDate = $hour->getStop();

                    $diff = $stopDate->diff($startDate);
                    $diff_in_hrs = $diff->h + ($diff->days * 24) + ($diff->i / 60);
                    $registeredHours = $registeredHours + $diff_in_hrs;
                }
            }
            //var_dump($task->getId());
        }
        return $registeredHours;
    }

    public static function getAllTasksOnProject($projectID){
        $tasksOnProject = TaskQuery::create()->filterByProjectId($projectID)->find();
        return $tasksOnProject;
    }

    public static function getTotalTasksFinishedAndOngoing($projectID){
        $totalTasksFinished = 0;
        $totalTasksOnProject = 0;
        $tasksOnProject = self::getAllTasksOnProject($projectID);
        foreach($tasksOnProject as $task){
            if($task->getWorkStatus() == 'FINISHED'){
                $totalTasksFinished = $totalTasksFinished + 1;
                $totalTasksOnProject = $totalTasksOnProject + 1;
            }
        }
        $res = array('totalTasksFinished'=> $totalTasksFinished, '$totalTasksOnProject' => $totalTasksOnProject);

        return $res;
    }

    public static function getTotalNumberOfFinishedTasks($projectID){
        $tasks = 0;
        $workstatus = 'FINISH';
        $numberOfTasks = TaskQuery::create()->findByProjectId($projectID);
        foreach($numberOfTasks as $task){
            if($task->getStatusId() == $workstatus){
                $tasks++;
            }
        }
        return $tasks;
    }
}