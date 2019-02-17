<?php
/**
 * Created by PhpStorm.
 * User: nor28349
 * Date: 16.03.2017
 * Time: 21:50
 */


require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/ProjectTeamsFetcher.class.php");
use Propel\Runtime\Propel;


if(isset($_POST['type'])){
    switch($_POST['type']){

        case 'get_project_details':
            $projId = intval($_POST['selected_project']);

            $freeTeams = array();
            $selectedTeamsJSON = array();
            $selectedTeamsArray = array();

            $selectedTeams = TeamProjectQuery::create()->filterByProjectId($projId)->find();
            $allTeamsProject = TeamProjectQuery::create()->find();
            $allTeams = TeamQuery::create()->find();

            //echo $allTeams;
            for($x = 0; $x < sizeof($selectedTeams); $x++){
                $selectedTeamsArray[$x] = $selectedTeams[$x]->getTeamId();
                $name = TeamQuery::create()->findOneById($selectedTeamsArray[$x])->getName();
                array_push($selectedTeamsJSON, array('id' => $selectedTeamsArray[$x],
                    'name' => $name
                ));
            }

            for ($x = 0; $x < sizeof($allTeamsProject); $x++){
                if ($allTeamsProject[$x]->getProjectId() != $projId){
                    //echo 'current project Id '.$allTeamsProject[$x]->getProjectId(). ' not equal, '. ' to selected project '. $projId.PHP_EOL;
                    $id = $allTeamsProject[$x]->getTeamId();
                    //echo 'Team Id '. $id. ' ';
                    if (!in_array($id,$selectedTeamsArray)){
                        //echo 'is not in array, '.PHP_EOL;
                        array_push($selectedTeamsArray, $id);

                        $name = TeamQuery::create()->findOneById($id)->getName();
                        array_push($freeTeams, array('id' => $id,
                            'name' => $name
                        ));
                    }
                    else{
                        //echo ' is in array,  '.PHP_EOL;
                    }
                }else{
                    //echo 'current project id Equal to selected project '.PHP_EOL;
                }
            }
            // adding teams which does not have team project relation yet
            for ($x = 0; $x < sizeof($allTeams); $x++){
                $id = $allTeams[$x]->getId();
                if (!in_array($id,$selectedTeamsArray)){
                    $name = TeamQuery::create()->findOneById($id)->getName();
                    array_push($freeTeams, array('id' => $id,
                        'name' => $name
                    ));
                }
            }

            $projectData = array();

            $project = ProjectQuery::create()->findOneById($projId);
            $project_Start = $project->getStart()->format('d/m/Y');
            $project_End = $project->getEnd()->format('d/m/Y');

            array_push($projectData, array('name'=>$project->getName(),
                                    'status'=>$project->getStatusId(),
                                    'start'=>$project_Start,
                                    'end'=>$project_End
            ));

            if($project != null){
                $res = new stdClass();
                $res->success='true';
                $res->projects = $projectData;
                $res->selectedTeams = $selectedTeamsJSON;
                $res->freeTeams = $freeTeams;

                //$data = [ 'success' => 'true', 'message' => $projectData, 'projectTeams' => $selectedTeams, 'freeTeams' => $freeTeams];
                //echo json_encode($data);
                echo json_encode($res);
            }
            else{
                $message = "Error";
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);
            }

            break;
        case 'update_project':
            $updateProject = new Project();
            $project_id = $_POST['project_select'];
            $project_new_name = $_POST['project_name_manage'];
            //var_dump($_POST['selected_teams']);

            $project_new_status = $_POST['project_status'];

            $message = $updateProject::UpdateProject($project_id,$project_new_name,$_POST['manage_project_start'],$_POST['manage_project_end'],$project_new_status, $_POST['selected_teams']);

            if($message == 'true'){
                $message = "Prosjektet er lagret";
                $data = [ 'success' => 'true', 'message' => $message];
                echo json_encode($data);
            }
            else{
                //$message = "Error, Prosjektet ble ikke lagret !";
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);
            }

            break;
        case 'delete_project':
            $project_to_be_deleted = $_POST['project_name_delete'];
            $message = Project::DeleteProject($_POST['project_name_delete']);

            if($message == 'true'){
                $message = "Prosjektet er slettet";
                $messageType = "success";


                $data = [ 'success' => 'true', 'message' => $message];
                echo json_encode($data);

            }else{
                //$message = "Problem med å slette prosjeket";
                $messageType = "error";

                $message = "Prosjektet kan ikke slettes";
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);

            }

            break;
        case 'create_project':
            try {
                $teams = array();
                $teams = explode(',', $_POST['teamId']);
                $project = $_POST['project_name'];

                $con = Propel::getWriteConnection(\Map\ProjectTableMap::DATABASE_NAME);
                $message = "";

                $message = Project::CreateProject($project, $_POST['create_project_start'], $_POST['create_project_end'], $teams, $_POST['customerName'], $_POST['customerAddress'], $_POST['customerContactPerson'], $_POST['customerEmail']);

                if($message == 'true'){
                    $message = "Prosjekt ".$project." er opprettet!";
                    $messageType = "success";
                    $data = [ 'success' => 'true', 'message' => $message];
                    echo json_encode($data);
                }
                else{
                    $messageType = "error";
                    $message = $pe->getMessage();
                    $data = ['success' => 'false', 'message' => $message];
                    echo json_encode($data);
                    exit();
                }


                break;
            }catch (\Propel\Runtime\Exception\PropelException $pe) {
                $messageType = "error";
                $message = $pe->getMessage();
                $data = ['success' => 'false', 'message' => $message];
                echo json_encode($data);
                exit();
            }
    }
}
else{
    $message = "error - else";
    $data = [ 'success' => 'false', 'message' => $message];
    echo json_encode($data);
}






