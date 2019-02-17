<?php

use Base\TimeRegistration as BaseTimeRegistration;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for representing a row from the 'timeregistration' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TimeRegistration extends BaseTimeRegistration
{
    public static function RegisterTime($from,$until,$place,$task,$comment,$user_id,$team_id,$task_id)
    {
        $con = Propel::getWriteConnection(\Map\TimeRegistrationTableMap::DATABASE_NAME);
        $timeReg = new TimeRegistration();

        //echo var_dump($until < $from);
        /*$d1 = new DateTime($from);
        $d2 = new DateTime($until);

        $interval = $d1->diff($d2);
        echo $interval->format('%R%a days');*/
        $message = "";

        if ($from == 'Tomt' || $until == 'Tomt' || $user_id == '' || $team_id == '' || $task_id == '') {
            $message = "error, vennlig fyll alle feltene";
            return $message;
        } else {
            if ($until < $from){
                $message = "slutt tidspunkt må være senere enn starttidspunkt";
                return $message;
            }
            //converting ids from strings to int
            $u_id = (int)$user_id;
            $te_id = (int)$team_id;
            $ta_id = (int)$task_id;

            //converting strings to dates
            $from = strtr($from, '+', ' ');
            $from = date("Y-m-d H:i:s", strtotime($from));

            $until = strtr($until, '+', ' ');
            $until = date("Y-m-d H:i:s", strtotime($until));

            if (TimeRegistrationQuery::create()->findByUserId($u_id)->count() == 0){
                // user didnt register hours
                $timeReg->setStart($from);
                $timeReg->setStop($until);

                $timeReg->setPlace($place);
                $timeReg->setPredefinedtask($task);

                $comment = strtr($comment, '+', ' ');
                $timeReg->setComment($comment);
                $timeReg->setActive('true');

                $timeReg->setUserId($u_id);
                $timeReg->setTaskId($ta_id);
                $timeReg->setTeamId($te_id);


                $con->beginTransaction();

                if ($timeReg->save() != 0) {
                    $con->commit();
                    $message = "true";
                } else {
                    $message = "error";
                }

                return $message;
            }
            else{ // user has registrations, checking for no double registration
                //converting strings to dates
                $from = strtr($from, '+', ' ');
                $from = date("Y-m-d H:i:s", strtotime($from));

                $until = strtr($until, '+', ' ');
                $until = date("Y-m-d H:i:s", strtotime($until));

                $dtStart = new DateTime($from);
                $dtEnd = new DateTime($until);

                $overlap = false;

                $user_timereg = TimeRegistrationQuery::create()->findByUserId($u_id);
                for ($i=0; $i< $user_timereg->count(); $i++){

                    $old_dtEnd = strtotime($user_timereg[$i]->getStop()->format('Y-m-d H:i:s'));
                    $old_dtEnd = date( 'Y-m-d H:i:s', $old_dtEnd );
                    $old_dtEnd = new DateTime($old_dtEnd);

                    $old_dtStart = strtotime($user_timereg[$i]->getStart()->format('Y-m-d H:i:s'));
                    $old_dtStart = date( 'Y-m-d H:i:s', $old_dtStart );
                    $old_dtStart = new DateTime($old_dtStart);

                    //var_dump($dtStart > $old_dtStart);
                    //var_dump($dtStart < $old_dtEnd);

                    if ($dtStart > $old_dtStart && $dtStart < $old_dtEnd){
                        $message = 'time registrering kan ikke overlappe tidligere registreringer !';
                        //echo 'already registration, new start is smaller than registered stop';
                        $overlap = true;
                        return $message;
                    }

                }

                if (!$overlap){
                    $timeReg->setStart($from);
                    $timeReg->setStop($until);

                    $timeReg->setPlace($place);
                    $timeReg->setPredefinedtask($task);

                    $comment = strtr($comment, '+', ' ');
                    $timeReg->setComment($comment);
                    $timeReg->setActive('true');

                    $timeReg->setUserId($u_id);
                    $timeReg->setTaskId($ta_id);
                    $timeReg->setTeamId($te_id);

                    $con->beginTransaction();

                    if ($timeReg->save() != 0) {
                        $con->commit();
                        $message = "true";
                    } else {
                        $message = "error";
                    }
                    return $message;
                }
            }
        }
    }

    public static function UpdateTimeStatus($id){
        $con = Propel::getWriteConnection(\Map\TimeRegistrationTableMap::DATABASE_NAME);
        $user_reg = TimeRegistrationQuery::create()->findPk($id);
        $message = "";

        if($user_reg->getActive() == 'true'){
            $user_reg->setActive('false');
        }
        elseif($user_reg->getActive() == 'false')
            $user_reg->setActive('true');

        $con->beginTransaction();

        if($user_reg->save() != 0){
            $con->commit();
            $message = "true";
        }else{
            $message = "false";
        }
        return $message;
    }


}
