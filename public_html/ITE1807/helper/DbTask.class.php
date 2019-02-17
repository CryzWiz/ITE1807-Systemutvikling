<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 20/02/2017
 * Time: 18:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class DbTask{
    public static function  ValidateLink($email, $vlink)
    {

        // get the PDO connection object from Propel
        $con = Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);

        $user = UserQuery::create()->findOneByEmail($email);
        $link   = ValidLinkQuery::create()->findPk($user->getId(), $con);

        if( $link == null || $vlink != $link->getValidlink()){
            return 6;
        }

        try {
            $con->beginTransaction();

            // set Validated = true
            $user->setValidated(true);
            $user->save($con);
            // delete this link from ValidLink table
            $link->delete($con);

            $con->commit();

        } catch (Exception $e) {
            $con->rollback();
            return 1;
        }

        return 0;
    }



public static function CreateAccount($email, $username, $firstname, $lastname, $password, $isPermanent){

    include(dirname(__DIR__, 1) . '/helper/su17_mailer.php');


        $con = Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        $user->setUserInfo(new UserInfo());
        $user->setPassExpiresAt(getTimestampAt());
        $user->setPermanent($isPermanent);
        $con->beginTransaction();
    try{
        //Internal errors:
        if($user->save() == 0) {
            $con->rollback();
            //insert row into user table failed.
            redirect("/controller/info.php?msid=101"); // Redirecting to info page
            exit();
        }
        else {
            //error sending validation link
            $res = send_validation_mail($email);
            if($res==0){
                $con->commit();
            }
            else{
                $con->rollback();
            }
            //$_SESSION['login_user']=$username; // Initializing Session
            redirect("/controller/info.php?msid=".$res); // Redirecting to info page
            exit();
        }

    }
    catch(Exception $ex){
        $con->rollback();
    }

}

    /**
     * Find all members of team.
     * @param     ObjectCollection|User[] $users collection
     * @return array[int] for given collection of users
     */
    public static function toIdArray($col){

        $ids = array();
        foreach($col as $u){
            array_push($ids, $u->getId());
        }

        return $ids;
    }

}


