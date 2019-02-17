<?php
/**
 * Created by PhpStorm.
 * User: nor28349
 * Date: 24.04.2017
 * Time: 21:22
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectTasksFetcher.class.php");

if(isset($_POST['type'])) {
    switch ($_POST['type']) {
        /**
         * Fetch all the tasks for this project
         */
        case 'loadProjectTasks':
            $projectTasks = TaskQuery::create()->findByProjectId($_POST['project_id']);

            $calendarEvent = array();

            if(!$projectTasks == null){

                foreach($projectTasks as $task){
                    $t_Start = $task->getStart()->format('Y-m-d');
                    $t_End = $task->getEnd()->format('Y-m-d');
                    $calendarEvent[] = array('id' => $task->getId(),
                                             'name' => $task->getName(),
                                             'location' => "",
                                             'startDate' => $t_Start,
                                             'endDate' => $t_End);
                }

                $res = new stdClass();
                $res->success='true';
                $res->dataSource = $calendarEvent;

            }
            else{
                $res = new stdClass();
                $res->success='false';

            }
            /**
             * return the result -> echo it to the js script in jason form
             */
            if(!$res == null){
                //echo ($calendarEvent);
                echo json_encode($res);
            }
            /**
             * Done!
             */
            break;
    }
}



