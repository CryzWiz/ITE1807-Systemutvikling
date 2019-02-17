<?php
/**
 * Created by PhpStorm.
 * User: Allan Arnesen
 * Date: 24.02.2017
 * Time: 10.30
 */
session_start();
// Fetch all supporting classes
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/TaskTimeRegUser.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectTeamsFetcher.class.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectTasksFetcher.class.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectStatusBarsFetcher.class.php");

// load the main template
$template = $twig->load('dashboard.twig');

// Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
// Fetch project tasks
$projectTasks = ProjectTasksFetcher::fetchProjectTasks($_GET['projectId']);
$data['projectTasks'] = $projectTasks;
// Fetch the project name
$project = ProjectQuery::create()->findOneById($_GET['projectId']);
// Set page title to be Dashboard for: + project_name
$data['page_title'] = 'Dashboard for: '.$project->getName();
// Set project_name as it's own twig data variable
$data['project_name'] = $project->getName();
// Set project start and end dates
$data['project_startdate'] = $project->getStart()->format('d/m/y');
$data['project_enddate'] = $project->getEnd()->format('d/m/y');

$data['isPrivate'] = false;
$data['role'] = "";

// Used to generate the user graphs, amongst other
$data['user_id'] = $_SESSION['user_id'];
$data['projectId'] = $_GET['projectId'];

// getting userId for the teamleader
$team_id = TeamProjectQuery::create()->findOneByProjectId($_GET['projectId'])->getTeamId();
$data['teamleaderId'] = UserTeamQuery::create()->findOneByTeamId($team_id)->getUserId();

$data['estimatedHoursForProject'] = ProjectStatusbarsFetcher::getAllEstimatedHours($_GET['projectId']);
$data['registeredHoursForProject'] = ProjectStatusbarsFetcher::getTotalRegisteredHours($_GET['projectId']);
$data['totalNumberOfTasksOnProject'] = sizeof($projectTasks);
$data['completedProjectTasks'] = ProjectStatusbarsFetcher::getTotalNumberOfFinishedTasks($_GET['projectId']);
// Fetch all the teams on this project and add them to twig
//echo $data['completedProjectTasks'];
$data['teamleader_holder'] = ProjectTeamsFetcher::fetchProjectTeams($_GET['projectId']);

//Get project info
$data['projectInfo'] = ProjectInfoQuery::create()->findPk($_GET['projectId']);
//var_dump($data['projectInfo']);

// Finally render the page to the user
echo $template->render($data);