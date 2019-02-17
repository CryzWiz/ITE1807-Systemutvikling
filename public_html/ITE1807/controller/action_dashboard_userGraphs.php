<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 12.04.2017
 * Time: 22.02
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/TaskTimeRegUser.php");

if(isset($_POST['type'])) {
    switch($_POST['type']) {
        /**
         * Fetch all the hours the user have registered to this project
         */
        case 'loadUserHoursGraph':
            /**
             * Fill a array with hour registrations for this project -> hour Objects are created here.
             */
            $userHoursRegistrations = getAllHoursForThisProject($_POST['user_id'], $_POST['project_id']);
            /**
             * Trying to pass all the hour registrations to sumAllHours to get a json
             * string generated to use in the morris-chart
             */
            $userHoursPrTask = sumAllHours($userHoursRegistrations);
            /**
             * Put the data we found in the result array
             * Currently returns all data
             * TODO:: don't return $userHoursRegistrations -> Not needed for the graph
             */

            if(!$userHoursRegistrations == null){
                $res = new stdClass();
                $res->success='true';
                //$res->hours = $userHoursRegistrations;
                $res->hoursPrTask = $userHoursPrTask;

            }
            else{
                $res = new stdClass();
                $res->success='false';
            }
            /**
             * return the result -> echo it to the js script in jason form
             */
            if(!$res == null){
                echo json_encode($res);
            }
            /**
             * Done!
             */
            break;

    }
}

function getAllHoursForThisProject($user_id, $project_id){
    $res = [];
    /**
     * Fetch all the registrations for this user on this project
     */
    $temp = TimeRegistrationQuery::create()->joinWithTask()
        ->filterByUserId($user_id)
        ->useTaskQuery()
        ->filterByProjectId($project_id)
        ->endUse()
        ->find();
    /**
     * Create hour objects from every registration
     */
    foreach($temp as $p){
        $prj= TaskTimeRegUser::create($p);
        array_push($res,$prj);
    }
    /**
     * Return registered hours
     */
    return $res;
}

function sumAllHours($obj){
    $res = [];
    $data = array();
    $sum_hours_by_id = [];
    $tasks_names = [];
    $tasks_estimated_hours = [];
    $counter = 0;
    foreach($obj as $p) {
        /**
         * finding time difference in hours
         */
        $startDate = new DateTime($p->timeRegStart);
        $stopDate = new DateTime($p->timeRegStop);
        $diff = $stopDate->diff($startDate);
        $diff_in_hrs = $diff->h + ($diff->days * 24) + ($diff->i / 60);

        if (isset($sum_hours_by_id[$p->timeRegTaskId]) && $sum_hours_by_id[$p->timeRegTaskId] > 0) {
            $sum_hours_by_id[$p->timeRegTaskId] = $sum_hours_by_id[$p->timeRegTaskId] + $diff_in_hrs;

        } else {
            $tasks_names[$p->timeRegTaskId] = $p->taskName;
            $tasks_estimated_hours[$p->timeRegTaskId] = $p->taskPlannedhours;
            $sum_hours_by_id[$p->timeRegTaskId] = $diff_in_hrs;

        }
        if(!in_array($p->timeRegTaskId, $res)){
            array_push($res, $p->timeRegTaskId);
        }
    }

    /**
     * Returning the data in object form. jason_encode it with the rest of the result array
     */
    for ($i =0; $i < sizeof($res); $i++){

        $data[] = array('y' => $tasks_names[$res[$i]], 'a' => $tasks_estimated_hours[$res[$i]], 'b' => $sum_hours_by_id[$res[$i]]);
    }
    return $data;
}