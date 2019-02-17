<?php
/**
 * Created by PhpStorm.
 * User: nor28349
 * Date: 23.03.2017
 * Time: 14:42
 */

use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/TaskDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/HoursDTO.class.php");

if(isset($_POST['type'])){
    switch($_POST['type']){
        case 'loadTeams':
            $teams = getTeamsbyUser($_POST['user_id']);
            if(!$teams == null){
                $res = new stdClass();
                $res->success='true';
                $res->projects = $teams;
            }else{
                $res = new stdClass();
                $res->success='false';
            }
            if(!$res == null){
                //$data = [ 'success' => 'true', 'projects' => $res];
                echo json_encode($res);
            }
            break;
        case 'findProject':
            $teamProject = getProjectsByTeam($_POST['team_id']);
            if(!$teamProject == null){
                $res = new stdClass();
                $res->success='true';
                $res->projects = $teamProject;
            }else{
                $res = new stdClass();
                $res->success='false';
            }
            if(!$res == null){
                //$data = [ 'success' => 'true', 'projects' => $res];
                echo json_encode($res);
            }
            break;
        case 'findTasks':
            $projectTask = getTasksByTeamAndProject($_POST['team_id'], $_POST['project_id']);
            if(!$projectTask == null){
                $res = new stdClass();
                $res->success='true';
                $res->tasks = $projectTask;
            }else{
                $res = new stdClass();
                $res->success='false';
            }
            if(!$res == null){
                //$data = [ 'success' => 'true', 'projects' => $res];
                echo json_encode($res);
            }
            break;
        case 'register_time':
            try {
                $con = Propel::getWriteConnection(\Map\TimeRegistrationTableMap::DATABASE_NAME);
                $message = "";

                $message = TimeRegistration::RegisterTime($_POST['from'],
                                                $_POST['until'],
                                                $_POST['place'],
                                                $_POST['predefTask'],
                                                $_POST['comment'],
                                                $_POST['user_id'],
                                                $_POST['team_id'],
                                                $_POST['task_id']);

                if($message == 'true'){
                    $message = "timer ble registrert!";
                    $messageType = "success";
                    $data = [ 'success' => 'true', 'message' => $message];
                    echo json_encode($data);
                }
                else{
                    $messageType = "error";
                    $data = [ 'success' => 'false', 'message' => $message];
                    echo json_encode($data);
                }

            }catch (\Propel\Runtime\Exception\PropelException $pe) {
                $messageType = "error";
                $message = $pe->getMessage();
                $data = ['success' => 'false', 'message' => $message];
                echo json_encode($data);
                exit();
            }
            break;
        case 'ToggleTimeStatus':
            $con = Propel::getWriteConnection(\Map\TimeRegistrationTableMap::DATABASE_NAME);
            $message = "";

            $message = TimeRegistration::UpdateTimeStatus($_POST['reg_id']);

            if($message == 'true'){

                $message = "Time status er endret";
                $messageType = "success";
                $data = [ 'success' => 'true', 'message' => $message];
                echo json_encode($data);
            }
            else{
                $messageType = "error";
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);
            }
            break;
        case 'loadHours':
            $userHours = getAllHours($_POST['user_id']);
            if(!$userHours == null){
                $res = new stdClass();
                $res->success='true';
                $res->hours = $userHours;
            }else{
                $res = new stdClass();
                $res->success='false';
            }
            if(!$res == null){
                //$data = [ 'success' => 'true', 'projects' => $res];
                echo json_encode($res);
            }

            break;
    }
}

function getProjectsByTeam($teamid)
{
    $res = [];
    $temp = ProjectQuery::create()
        ->useTeamProjectQuery()
        ->filterByTeamId($teamid)
        ->endUse()
        ->find();

    foreach($temp as $p){
        $prj= ProjectDTO::create($p);
        array_push($res,$prj);
    }
    return $res;

}

function getAllHours($user){
    $res = [];
    $temp = TimeRegistrationQuery::create()->joinWithTeam()->joinWithTask()->findByUserId($user);

    foreach($temp as $p){
        $prj= HoursDTO::create($p);
        array_push($res,$prj);
    }
    return $res;
}

function getStartHour(){
    $res = [];
    $temp = TimeRegistrationQuery::create()->findByUserId($_SESSION['user_id']);

    if ($temp->count() > 0) {
        for ($i = 0; $i < $temp->count(); $i++) {
            $start_regs[$i] = date_format($temp[$i]->getStart(), 'Y-m-d H:i:s');
        }

        foreach ($start_regs as $p) {
            $prj = HoursDTO::create($p);
            array_push($res, $prj);
        }
    }
}

function getStopHour(){
    $res = [];
    $temp = TimeRegistrationQuery::create()->findByUserId($_SESSION['user_id']);

    if ($temp->count() > 0) {
        for ($i = 0; $i < $temp->count(); $i++) {
            $stop_regs[$i] = date_format($temp[$i]->getStop(), 'Y-m-d H:i:s');
        }

        foreach ($stop_regs as $p) {
            $prj = HoursDTO::create($p);
            array_push($res, $prj);
        }
    }
}

function getTasksByTeamAndProject($team_id, $prj_id)
{
    $res = [];
    $temp = TaskQuery::create()->filterByTeamId($team_id)->findByProjectId($prj_id);

    foreach($temp as $t){
        $tsk= TaskDTO::create($t);
        array_push($res,$tsk);
    }
    return $res;

}

function getTeamsbyUser($user_id){
    $res = [];
    $temp = UserTeamQuery::create()->findByUserId($user_id);

    foreach($temp as $t){
        $team= TeamDTO::create($t);
        array_push($res,$team);
    }
    return $res;

}
/*
$date = $_POST['date'];
$from_time = $_POST['from'];
$until_time = $_POST['until'];
$place = $_POST['place'];
$comment = $_POST['comment'];

return $date;
*/