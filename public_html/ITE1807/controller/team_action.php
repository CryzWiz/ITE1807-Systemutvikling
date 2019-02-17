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
use Propel\Runtime\Propel;

if ( isset( $_POST['type'] ) ) {
    header('Content-type: application/json');
    try{

        switch($_POST['type']){
            case 'change_team_leader':
                $res = changeTeamLeader($_POST['team_id'], $_POST['user_id'], $_POST['logged_uid']);
                echo json_encode($res);
                break;
            default:
                $res = new StdClass();
                $res->success=false;
                $res->message="Wrong parameter: type is not set correctly.";
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

function changeTeamLeader($teamId, $userId, $logged_uid){
    $res = new stdClass();
    $con = Propel::getWriteConnection(\Map\UserTeamTableMap::DATABASE_NAME);
    try{
        //TODO: sanitize input and check permissions for user $logged_uid
        //$team = TeamQuery::create()->findPk($teamId);
        $tid = intval($teamId);
        $uid = intval($userId);
        $logged = intval($logged_uid);
        $con->beginTransaction();
        $ut = UserTeamQuery::create()->filterByTeamId($tid)
                                    ->findOneByUserId($uid);
        UserTeamQuery::create()->filterByTeamId($tid)
                                ->update(array('Isteamleader' => false),$con);

        if(!$ut){
            $ut = new UserTeam();
            $ut->setUserId($uid);
            $ut->setTeamId($tid);
        }
        $ut->setIsteamleader(true);
        $ut->save($con);


        $con->commit();

        $res->success=true;
        $res->message='Team leadership is updated.';

    }
    catch(Exception $ex){
        $con->rollBack();
        $res->success=false;
        $res->message=$ex->getMessage();
    }
    return $res;
}

