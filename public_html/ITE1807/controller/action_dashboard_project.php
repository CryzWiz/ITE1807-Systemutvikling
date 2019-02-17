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

            $calendarTasks = array();

            if(!$projectTasks == null){

                foreach($projectTasks as $task){
                    $t_Start = $task->getStart()->format('Y-m-d');
                    $t_End = $task->getEnd()->format('Y-m-d');
                    $calendarTasks[] = array('id' => $task->getId(),
                                             'name' => $task->getName(),
                                             'userId' => "",
                                             'projectId' => $task->getProjectId(),
                                             'location' => "",
                                             'startDate' => $t_Start,
                                             'endDate' => $t_End);
                }

                $res = new stdClass();
                $res->success='true';
                $res->dataSource = $calendarTasks;

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

        case 'loadProjectEvents':
            $projectEvents = CalendarQuery::create()->findByProjectId($_POST['project_id']);

            $calendarEvent = array();

            if(!$projectEvents == null){

                foreach($projectEvents as $task){
                    $t_Start = $task->getStartDate()->format('Y-m-d');
                    $t_End = $task->getEndDate()->format('Y-m-d');
                    $calendarEvent[] = array('id' => $task->getId(),
                        'name' => $task->getEventname(),
                        'userId' => $task->getUserId(),
                        'projectId' => $task->getProjectId(),
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
        case 'loadContextMenuItem' :
            // create contextMenu for the calendar based if user is team leader or normal user
            $contextMenu = array();

            $res = new stdClass();
            $res->success='true';

            // load different context menu ites if logged user is team leader or not
            if($_POST['user_id']){

                $contextMenu[0] = array('name' => 'Rediger',
                                        'click' => 'editEvent');
                $contextMenu[1] = array('name' => 'Slett',
                                        'click' => 'deleteEvent');

                $res->contextMenuItems = $contextMenu;
            }else{
                //$contextMenu[] = array('name' => 'Ny event',
                                        //'click' => 'editEvent');
                $contextMenu = [];
                $res->contextMenuItems = $contextMenu;
            }

            if(!$res == null){
                //echo ($calendarEvent);
                echo json_encode($res);
            }

            break;

        case 'saveEventToDB':
            // saving event to database, event can be either task or new event (ie meeting ....)
            switch($_POST['typeEvent']){
                case 'event':
                    $eventJSON = $_POST['event'];
                    $event = json_decode($eventJSON,true);
                    //var_dump($event);
                    //echo $event['regards'];
                    //echo $event['location'];

                    $message = Calendar::createEvent(intval($event['projectId']), intval($event['userId']), $event['name'], $event['regards'], $event['location'], $event['startDate'], $event['endDate']);

                    break;
            }
            break;
        case 'loadCalendar':

            $events = array();
            $tasks = array();
            $calendar = array();

            $tasks = getProjectCalendarTasks($_POST['project_id']);
            $events = getProjectCalendarEvents($_POST['project_id']);

            //combining the two arrays into one
            for ($i =0; $i < sizeof($tasks); $i++){

                $calendar[] = array('id' => $tasks[$i]['id'],
                                    'name' => $tasks[$i]['name'],
                                    'userId' => $tasks[$i]['userId'],
                                    'projectId' => $tasks[$i]['projectId'],
                                    'location' => $tasks[$i]['location'],
                                    'regards' => $tasks[$i]['regards'],
                                    'startDate' => $tasks[$i]['startDate'],
                                    'endDate' => $tasks[$i]['endDate'],
                                    'type' => 'task');
            }
            for ($i =0; $i < sizeof($events); $i++){

                $calendar[] = array('id' => $events[$i]['id'],
                    'name' => $events[$i]['name'],
                    'userId' => $events[$i]['userId'],
                    'projectId' => $events[$i]['projectId'],
                    'location' => $events[$i]['location'],
                    'regards' => $events[$i]['regards'],
                    'startDate' => $events[$i]['startDate'],
                    'endDate' => $events[$i]['endDate'],
                    'type' => 'event');
            }



            $res = new stdClass();
            $res->success='true';
            $res->dataSource = $calendar;
            echo json_encode($res);
            break;

    }
}

function getProjectCalendarTasks($projsectId){
    $projectTasks = TaskQuery::create()->findByProjectId($projsectId);

    $calendarTasks = array();

    if(!$projectTasks == null) {

        foreach ($projectTasks as $task) {
            $t_Start = $task->getStart()->format('Y,m,d');
            $t_End = $task->getEnd()->format('Y,m,d');
            $calendarTasks[] = array('id' => $task->getId(),
                'name' => $task->getName(),
                'userId' => "",
                'projectId' => $task->getProjectId(),
                'location' => "",
                'regards' => "",
                'startDate' => $t_Start,
                'endDate' => $t_End,
                'type' => 'task');
        }
    }
    return $calendarTasks;
}

function getProjectCalendarEvents($projsectId){
    $projectEvents = CalendarQuery::create()->findByProjectId($projsectId);

    $calendarEvent = array();

    if(!$projectEvents == null) {

        foreach ($projectEvents as $event) {
            $t_Start = $event->getStartDate()->format('Y,m,d');
            $t_End = $event->getEndDate()->format('Y,m,d');
            $calendarEvent[] = array('id' => $event->getId(),
                'name' => $event->getName(),
                'userId' => $event->getUserId(),
                'projectId' => $event->getProjectId(),
                'location' => $event->getLocation(),
                'regards' => $event->getRegards(),
                'startDate' => $t_Start,
                'endDate' => $t_End,
                'type' => 'event');
        }
    }
    return $calendarEvent;
}



