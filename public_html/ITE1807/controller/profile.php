<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 17/02/2017
 * Time: 18:40
 */


session_start();
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once dirname(__DIR__, 1) . "/helper/su17_func.php";
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/UserInfoDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/TaskDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectDTO.class.php");

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']))
{
    redirect('/index.php');
}

$user = UserQuery::create()->findPk($_SESSION['user_id']);
//$generalTemplate = $twig->load('generalTemplate.twig');
$template = $twig->load('profile.twig');

//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
$data['page_title'] = 'Profil for '.$user->getUsername();
$data['isPrivate'] = true;
$data['role'] = "";

$active_tab = getParamFromQueryString($_SERVER['QUERY_STRING'], 'active_tab');

if(isset($_GET['active_tab']))
    $data['active_tab'] = $active_tab;

if (isset($_SESSION['profileUpdateRequested'])) { // userinfo tab to be the active tab if an update of the user profile has been requested
    $data['active_tab'] = 'userinfo';
    $data['display_form_feedback'] = true;
    unset($_SESSION['profileUpdateRequested']);
}

$data['projects'] = ProjectQuery::create()->find(); // gets a list of all projects
$data['project_status'] = WorkStatusQuery::create()->find(); // gets a list of all status
$data['teams'] = TeamQuery::create()->find(); // gets a list of all teams
$data['inactive_users'] = UserQuery::create()->filterByActive(0)->find(); // gets all inactive users
$data['users'] = UserQuery::create()->find();

$data['user_time_registrations'] = TimeRegistrationQuery::create()->joinWithTeam()->joinWithTask()->findByUserId($_SESSION['user_id']);

$user_timereg = TimeRegistrationQuery::create()->findByUserId($_SESSION['user_id']);

if ($user_timereg->count() > 0){
    for ($i=0; $i< $user_timereg->count(); $i++){
        $start_regs[$i] = date_format($user_timereg[$i]->getStart(), 'Y-m-d H:i:s');
        $stop_regs[$i] = date_format($user_timereg[$i]->getStop(), 'Y-m-d H:i:s');
    }

    $data['start_regs'] = $start_regs;
    $data['stop_regs'] = $stop_regs;
}


$lteam = $user->getTeamsForTeamleaderRoleAsArray();

$uteam = $user->getTeamsForUserRoleAsArray();


$uprojects = $user->getAllUserProjects();


$data['leader_in_teams']= $user->getTeamsForTeamleaderRoleAsArray();
$data['team_selected_id']=(count($lteam) > 0)? key($lteam) : '';
$userDTO = UserDTO::create($user);
$uiDTO = UserInfoDTO::create(UserInfoQuery::create()->findPk($_SESSION['user_id']));

//var_dump($uteam);
$data['member_in_teams'] = $uteam;
$data['user_projects'] = $uprojects;

$data['user'] = $userDTO;
$data['user_id'] = $_SESSION['user_id'];
$data['userinfo'] = $uiDTO;

$userTeam = UserTeamQuery::create()->joinWithTeam()->findByUserId($_SESSION['user_id']);
$data['user_teams'] = $userTeam;
$data['last_times'] = $user->getLastTimeRegistrations();
//var_dump($data['last_times']);



if ($userTeam != null && $userTeam->count() > 0){
    $data['user_team_selected_id']=$userTeam->getFirst()->getTeamId();
    //$userProject = ProjectQuery::create()->joinWithTeamProject()->findById($data['user_team_selected_id']);
    $userProject = ProjectQuery::getProjectsDTOByTeamId($data['user_team_selected_id']);
    $data['user_projects'] = $userProject;
    //var_dump($userProject);
    if(count($userProject) > 0){
        $data['project_selected_id'] = $userProject[0]->id;
        //var_dump($data['user_projects']);

        $userTask = TaskQuery::getTasksDTOByProjectId($data['project_selected_id']);
        //$userTask = TaskQuery::create()->getTask($data['project_selected_id']);

        $data['assignments'] = $userTask;
        if($userTask && count($userTask) > 0)
            $data['assignment_selected'] = $userTask[0];
        //var_dump($data['assignment_selected']);
    }
}

//echo 'ok';

$data['statuses'] = WorkStatus::getAllAsArray();
$data['message'] = '';

//Show city by lookup
if ($postal = PostalQuery::create()->findOneByPostcode($uiDTO->postcode))
    $data['city'] = $postal->getCity();
else
    $data['city'] = "Lookup failed, no post code specified";

echo $template->render($data);


