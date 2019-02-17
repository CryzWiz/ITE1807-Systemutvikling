<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/17
 * Time: 18:43
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
//require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/TaskDTO.class.php");


if ( isset( $_POST['type'] ) ) {
    header('Content-type: application/json');
    try{

        switch($_POST['type']){
            case 'create_task':
                $res = createNewTask($_POST['project_id'],$_POST['team_id'], $_POST['task_name'], $_POST['task_hours'], $_POST['task_start'], $_POST['task_end']);
                echo json_encode($res);
                break;
            case 'update_task':
                //TODO: sanitize input
                $res = updateTask($_POST['task_id'],$_POST['task_name'], $_POST['task_hours'], $_POST['task_start'],$_POST['task_end'],$_POST['statusId']);

                echo json_encode($res);
                break;
            case 'delete_task':
                //TODO: sanitize input
                $res = deleteTask($_POST['task_id'],$_POST['user_id']);
                echo json_encode($res);
                break;
            default:
                $res = new StdClass();
                $res->success=false;
                $res->message="Wrong parameter: type is not set.";
                echo json_encode($res);
        }
    }
    catch(Exception $ex){
        $res = new StdClass();
        $res->success=false;
        $res->message=$ex->getMessage();
        echo json_encode($res);

    }

}
else{

    $data = [ 'success' => 'false', 'message' => 'Error'];
    header('Content-type: application/json');

    echo json_encode($data);
}

function createNewTask($projectId, $teamId, $task_name, $task_hours, $task_start, $task_end){
    $res = new stdClass();
    try{

        //TODO: sanitize input
        //$team = TeamQuery::create()->findPk($_POST['team_id']);
        //$project = ProjectQuery::create()->findPk($_POST['team_id']);
        $tp = TeamProjectQuery::create()->filterByProjectId(intval($projectId))
            ->findOneByTeamId(intval($teamId));
        //findPk(intval($_POST['project_id']),intval($_POST['team_id']));
        $task = new Task();

        $task->setTeamProject($tp);
        $task->setName($task_name);
        $task->setPlannedhours($task_hours);
        $start = str_replace('\\', '', $task_start);
        $end = str_replace('\\', '', $task_end);
        $startdate = DateTime::createFromFormat('d/m/Y', $start);
        $enddate = DateTime::createFromFormat('d/m/Y', $end);
        $curdate = new DateTime();
        //TODO: time check with prpject dates and current date...
        $task->setStart($startdate);
        $task->setEnd($enddate);

        if($task_hours > 0)
            $task->setPlannedhours($task_hours);
        else
            $task->setPlannedhours(0);

        $diff = $curdate->diff($startdate);
        if($diff->days != 0)
            $task->setStatusId('ONHOLD');
        else
            $task->setStatusId('PRGRSS');

        $task->save();
        $res->success=true;
        $res->message='Task created.';
        $res->task=TaskDTO::create($task);

    }
    catch(Exception $ex){
        $res->success=false;
        $res->message=$ex->getMessage();
        $res->task=null;
    }
    return $res;
}

function updateTask($taskId, $taskName, $task_hours, $task_start, $task_end, $statusId){

    $res = new stdClass();
    try{
        $task = TaskQuery::create()->findPk($taskId);
        $task->setName($taskName);
        $task->setStatusId($statusId);
        $start = str_replace('\\', '', $task_start);
        $end = str_replace('\\', '', $task_end);
        $startdate = DateTime::createFromFormat('d/m/Y', $start);
        $enddate = DateTime::createFromFormat('d/m/Y', $end);
        //$curdate = new DateTime();
        //TODO: time check with prpject dates and current date...
        $task->setStart($startdate);
        $task->setEnd($enddate);
        if($task_hours > 0)
            $task->setPlannedhours($task_hours);
        else
            $task->setPlannedhours(0);
        $task->save();

        $res->success=true;
        $res->message='Your changes were saved.';
        $res->task=$task;
    }
    catch(Exception $ex){
        $res->success=false;
        $res->message=$ex->getMessage();
        $res->task=null;
    }
    return $res;
}

function deleteTask($taskId, $userId){

    $res = new stdClass();
    $error = false;
    try{
        $task = TaskQuery::create()->findPk($taskId);
        $countTR = TimeRegistrationQuery::create()->where('TimeRegistration.Task_id = ?', $taskId)->count();
        $message = '';
        //TODO: check permissions for userId...
        if($countTR > 0){
            $message .= 'Cannot delete task which has time registrations.';
            $error=true;
        }
        if($task->getStatusId() != 'ONHOLD'){
            $message .= 'Cannot delete task that has been already started/finished';
            $error=true;
        }

        if($error){
            $res->success=false;
            $res->message=$message;
            $res->task=$task;
        }
        else{
            $task->delete();
            $res->success=true;
            $res->message='Task was deleted.';
            $res->task=$task;
        }

    }
    catch(Exception $ex){
        $res->success=false;
        $res->message=$ex->getMessage();
        $res->task=null;
    }
    return $res;
}