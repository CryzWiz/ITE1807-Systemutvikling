<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 13/03/17
 * Time: 18:42
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/DbTask.class.php");

$ids = json_decode('[' . $_POST['ids'] . ']', true);
$team_id = $_POST['team_id'];


$con = Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);
$con->beginTransaction();
$error = 0;
try{
    $team = TeamQuery::create()->findPk($team_id);
    if($team){
        $curusers = DbTask::toIdArray($team->getAllUsers());

        $toremove = array_diff($curusers, $ids);
        $toadd = array_diff($ids,$curusers);

        if(count($toremove)==0 && count($toadd)==0){
            $con->rollBack();
            $data = [ 'success' => 'true', 'message' => 'Nothing to change.'];
            header('Content-type: application/json');

            echo json_encode($data);
            exit();
        }


        //$containsSearch = count(array_intersect($search_this, $all)) == count($search_this);
        foreach($toremove as $id){
            $user = UserQuery::create()->findPk($id);
            $team = TeamQuery::create()->findPk($team_id);
            $ut = UserTeamQuery::create()->findOneByUserId($id);
            if(!$ut->getIsteamleader())
                $ut->delete();
        }

        $error=0;
        foreach($toadd as $id){
            $user = UserQuery::create()->findPk($id);
            if(!$user->getActive())
                continue;
            $userteam = UserTeamQuery::create()->findPk(array($user,$team));

            if($userteam==null){
                $ut = new UserTeam();
                $ut->setTeamId($team_id);
                $ut->setUserId($id);
                $ut->save();
            }
            else{
                $error=1;
                break;
            }
        }
        if($error == 0){
            $con->commit();
            $data = [ 'success' => 'true', 'message' => 'Your changes were saved.'];
            header('Content-type: application/json');

            echo json_encode($data);
        }
        else{
            $con->rollBack();
            $message ='';
            switch($error){
                case 1:
                    $message = 'User already belongs to the team';
            }$data = [ 'success' => 'false', 'message' => $message];
            header('Content-type: application/json');

            echo json_encode($data);

        }



    }
    else{
        $data = [ 'success' => 'false', 'message' => 'Wrong parameter.'];//
        header('Content-type: application/json');

        echo json_encode($data);
    }
}
catch(Exception $ex){

    $con->rollBack();
    $data = [ 'success' => 'false', 'message' => $ex->getMessage()];//
    header('Content-type: application/json');

    echo json_encode($data);
}


