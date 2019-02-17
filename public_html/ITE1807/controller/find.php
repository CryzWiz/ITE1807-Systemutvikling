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

    switch($_POST['type']){
        case 'team_changed':
            $users = getUsersByTeam($_POST['team_id']);
            $projects = getProjectsByTeam($_POST['team_id']);
            $res = new stdClass();
            $res->users = $users;
            $res->projects=$projects;
            echo  json_encode($res); //json_encode($users);
            break;
        case 'user_by_email':
            $users = findUserByEmail($_POST['email']);
            echo  $users->toJSON(); //json_encode($users);
            break;
        case 'tasks_by_team_and_project':
            $tasks = getTasksByTeamAndProject($_POST['team_id'], $_POST['project_id']);
            $res = new stdClass();
            $res->tasks = $tasks;
            echo json_encode($res);
            break;
        case 'task_by_id':
            $task = getTaskById($_POST['task_id']);
            $res = new stdClass();
            $res->task = $task;
            echo json_encode($res);
            break;
        default:
            echo "Wrong parameter: type is not set.";
    }

}
else{

    echo "Error";
}





function findUserByEmail($email)
{
    $users = new Propel\Runtime\Collection\ObjectCollection();
    $users->setModel('UserDTO');
    $temp = UserQuery::create()->findOneByEmail($email);

    if($temp){
        $user = UserDTO::create($temp);
        $users->append($user);
    }
    //returning collection with one user just for unified recieving.
    return $users;
}

function getUsersByTeam($teamid)
{
    $res = [];
    $team = TeamQuery::create()->findPk($teamid);
    if($team){
        $temp = $team->getAllUsers();

        foreach($temp as $user){
            $u= UserDTO::create($user);
            array_push($res, $u);
        }
    }
    return $res;

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

function getTaskById($task_id)
{
        $temp = TaskQuery::create()->findPK($task_id);

        return TaskDTO::create($temp);


}
