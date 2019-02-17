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
require_once(dirname(__DIR__, 1) . "/helper/HoursExDTO.class.php");
use Propel\Runtime\Propel;

if ( isset( $_POST['type'] ) ) {
    header('Content-type: application/json');
    try{

        switch($_POST['type']){
            case 'team_time_for_approval':
                if(isset($_POST['user_id']) && intval($_POST['user_id']>0)){
                    $res = getTimeRegForApprovalByTeamLeaderId($_POST['user_id']);// time regs for all teams where given user is teamleader
                    echo json_encode($res);
                }
                else{
                    $res = new StdClass();
                    $res->success=false;
                    $res->message="Wrong parameter: user_id is not set correctly.";
                    echo json_encode($res);
                }
                break;
            case 'approve_time':
                if(isset($_POST['ids']) && $_POST['ids'] && count($_POST['ids'])>0){
                    $res = approveTeamTime($_POST['ids']);
                    echo json_encode($res);
                }
                else{
                    $res = new StdClass();
                    $res->success=false;
                    $res->message="Wrong parameter: ids is not set correctly.";
                    echo json_encode($res);
                }
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

    $data = [ 'success' => 'false', 'message' => 'Error: type is not set.','request'=> json_encode($_POST)];
    header('Content-type: application/json');

    echo json_encode($data);
}

function getTimeRegForApprovalByTeamLeaderId($userId){
    $res = new stdClass();

    $arr = array();
    try{
        $times = TimeRegistrationQuery::create()
            ->useTeamQuery()
            ->useUserTeamQuery()
            ->filterByUserId($userId)
            ->filterByIsteamleader(true)
            ->endUse()
            ->endUse()
            ->filterByApproved(false);

        foreach($times as $time){
            $t= HoursExDTO::create($time);
            array_push($arr, $t);
        }

        $res->times=$arr;
        $res->success=true;
        $res->message='Times fo TeamLeader';

    }
    catch(Exception $ex){
        $res->times=null;
        $res->success=false;
        $res->message=$ex->getMessage();
    }
    return $res;
}

function approveTeamTime($ids){
    $res = new stdClass();

    try{
        $data = explode( ',', $ids );

        array_walk( $data, 'intval' );
        if(count($data)==0){
            $res->success=false;
            $res->message='Nothing to approve.';
            return $res;
        }
        $count = TimeRegistrationQuery::create()
            ->filterByPrimaryKeys($data)
            ->update(array('Approved' => true));

        $res->ids = $ids;
        $res->success=true;
        $res->message= '' . $count . ' time registrations approved.';

    }
    catch(Exception $ex){

        $res->success=false;
        $res->message=$ex->getMessage();
    }
    return $res;
}

