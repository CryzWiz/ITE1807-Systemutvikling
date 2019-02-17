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
require_once(dirname(__DIR__, 1) . "/helper/ReportHourDTO.class.php");
use Propel\Runtime\Propel;

if ( isset( $_POST['type'] ) ) {
    header('Content-type: application/json');
    try{

        switch($_POST['type']){
            case 'report_team_general_info':
                if(isset($_POST['user_id']) && intval($_POST['user_id']>0)){
                    $res = getTimeRegForReportByTeamLeaderId($_POST['user_id']);// time regs for all teams where given user is teamleader
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

function getTimeRegForReportByTeamLeaderId($userId){
    $res = new stdClass();

    $arr = array();
    try{
        $times = TimeRegistrationQuery::create()
            ->withColumn('TIMESTAMPDIFF(SECOND, timeregistration.Start,timeregistration.Stop)', 'Duration')
            ->withColumn('MIN(timeregistration.Start)', 'Start')
            ->withColumn('MAX(timeregistration.Stop)', 'Stop')
            ->useTeamQuery()
            ->useUserTeamQuery()
            ->filterByUserId($userId)
            ->filterByIsteamleader(true)
            ->endUse()
            ->endUse()
            ->filterByApproved(false)
            ->groupByUserId()
            ->groupByTeamId()
            ->groupByTaskId()
            ->select(array('User_idd', 'Team_id', 'Task_id', 'Start', 'Stop', 'Duration'))
            ->find();

        foreach($times as $row){
            $rh= ReportHourDTO::createFromArray($row);
            array_push($arr, $rh);
        }
        //var_dump($arr);
        $res->times=$arr;
        $res->success=true;
        $res->message='TimeReport for TeamLeader';

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

