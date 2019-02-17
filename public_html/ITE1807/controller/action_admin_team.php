<?php
/**
 * Created by PhpStorm.
 * User: nor28349
 * Date: 16.03.2017
 * Time: 21:50
 */


require_once(dirname(__DIR__, 1) . "/global_init.php");
use Propel\Runtime\Propel;


if(isset($_POST['type'])){
    switch($_POST['type']){
        case 'add_teamleader':
            $user_id = $_POST['user_id'];
            $team_id = $_POST['team_id'];
            $con = Propel::getWriteConnection(\Map\UserTeamTableMap::DATABASE_NAME);
            $message = "";
            try{

                /*
                //$team_already_has_leader = UserTeamQuery::create()->findByTeamId($team_id);
                if($team_already_has_leader){
                    $message = "Team har allerede leder";
                    $messageType = "error";
                    $data = [ 'success' => 'false', 'message' => $message];
                    echo json_encode($data);
                    exit();
                }
                else{*/
                $user_team = new UserTeam();
                $user_team->setTeamId($team_id);
                $user_team->setUserId($user_id);
                $user_team->setIsteamleader(1);

                if($user_team->save() != 0) {
                    $con->commit();
                    $message = "Ansatt er nå teamleder";
                    $messageType = "success";
                    $data = [ 'success' => 'true', 'message' => $message];
                    echo json_encode($data);
                    exit();
                }
                else {
                    $con->rollBack();
                    $message = "Rolling back";
                    $messageType = "error";
                    $data = [ 'success' => 'false', 'message' => $message];
                    echo json_encode($data);
                    exit();
                }

                /*}*/

            }catch (Exception $pe){
                $messageType = "error";
                $message = $pe->getMessage();
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);
                exit();
            }
        case 'create_team':
            $team = Team::CreateTeam($_POST['team_name']);
            $teamId = $team->getId();

            if($team == null) {
                $message = "En feil oppstod i forsøket på å lage teamet";
                $messageType = "error";
                $data = [ 'success' => 'false', 'message' => $message];
                echo json_encode($data);
            }
            else{
                $message = "Teamet er opprettet!";
                $messageType = "success";
                $data = [ 'success' => 'true', 'message' => $message, 'teamId' => $teamId];
                echo json_encode($data);
            }

            break;
        case 'delete_team':
            $team_id = $_POST['team_id'];
            $message = Team::DeleteTeam($team_id);
            if($message == 'true')
                $data = [ 'success' => 'true', 'message' => "Team slettet"];
            else
                $data = [ 'success' => 'false', 'message' => "Kan ikke slette team. Team er aktiv på et prosjekt"];

            echo json_encode($data);
            exit();
        case 'changeStatus':
            $user_id = $_POST['user_id'];
            $con = Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);
            $message = User::changePermanentById($user_id);

            if($message == 'innleid')
                $data = [ 'success' => $message, 'message' => "bruker endret til innleid"];
            elseif ($message == 'fast')
                $data = [ 'success' => $message, 'message' => "bruker endret til fast"];
            else
                $data = [ 'success' => $message, 'message' => "Error"];

            echo json_encode($data);
            exit();
        case 'changeKontoStatus':
            $user_id = $_POST['user_id'];
            $con = Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);
            $message = User::changeUserAccountStatusById($user_id);

            if($message == 'active')
                $data = [ 'success' => $message, 'message' => "bruker er nå aktiv"];
            elseif ($message == 'inactive')
                $data = [ 'success' => $message, 'message' => "bruker er nå inaktiv"];
            else
                $data = [ 'success' => $message, 'message' => "Error"];

            echo json_encode($data);
            exit();
    }
}






