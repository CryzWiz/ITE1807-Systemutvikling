<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 17/02/2017
 * Time: 00:25
 */

//session_start();

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_mailer.php");
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/UserInfoDTO.class.php");

$password_required= empty($_POST['password']) && !isset($_POST['newpass']);
if (empty($_POST['username']) || $password_required) {

    echo $twig->render('index.twig', array(
        'action_dir' => $GLOBALS['prj_dir'].'/controller/',
        'username' => '',
        'message' => 'Username or password is empty.' .$_SERVER['REMOTE_ADDR'],
        'messageType' => 'error'
    ));

}
else
{

    $nuser = UserQuery::create()    //// trying to find user by email or username
        ->select(array('id','Email','Validated'))
        ->filterByUserName($_POST['username'])
        ->_or()
        ->filterByEmail($_POST['username'])->findOne();


    //var_dump($nuser);


    if($nuser != null && $nuser['Validated'] )
    {
        if(isset($_POST['newpass'])){

            if(send_newpass_mail($nuser['Email'],$nuser['id'])==0){
                redirect("/controller/info.php?msid=7"); // Redirecting to info page
            }
            else{
                redirect("/controller/info.php?msid=1"); // Redirecting to info page
            }
            exit();
        }

            $user = UserQuery::create()->filterById($nuser['id'])
                ->filterByPassExpiresAt(array('min' => getTimestampAt(1)))
                ->joinWithUserInfo()
                ->findOne();

        //var_dump($user);

            if($user == null){
                $data = $GLOBALS['twigdata'];
                $data['username'] = $_POST['username'];
                $data['message'] = 'Wrong username or password.';
                $data['messageType'] = 'error';
                echo $twig->render('index.twig', $data);
            }
            else{
                if(checkPassword($_POST['password'], $user->getPassword())){ // SUCCESS: USER IS AUTHENTICATED




                    /*if(session_status() != PHP_SESSION_ACTIVE) {
                        //session_destroy();
                        //echo "Session starting";

                    }*/

                    session_start();


                    //$lteam = $user->getTeamsForTeamleaderRoleAsArray();
                    //$uteam = $user->getTeamsForUserRoleAsArray();

                    $_SESSION['user_id']=$user->getId(); // Storing logged user into session
                    $_SESSION['username']=$user->getUsername();
                    /*$_SESSION['email']=$user->getEmail();
                    $_SESSION['fullname']=$user->getFirstname() . ' ' . $user->getLastname();
                    $_SESSION['phone']= is_blank($user->getUserInfo()->getWorkPhone())?'N/A' : $user->getUserInfo()->getWorkPhone();
                    $_SESSION['mobile'] = is_blank($user->getUserInfo()->getMobilePhone())?'N/A' : $user->getUserInfo()->getMobilePhone();
                    $_SESSION['firstname']=$user->getFirstname();
                    $_SESSION['lastname']=$user->getLastname();
                    $_SESSION['role']=$user->getHtmlRoleName();
                    $_SESSION['leader_in_teams']= $user->getTeamsForTeamleaderRoleAsArray();
                    $_SESSION['teamusers']= array();
                    $_SESSION['leader_in_teams_selval']=(array_count_values($lteam) > 0)? reset($lteam) : '';
                    $_SESSION['isTeamleader']= $user->isTeamleader();
                    $_SESSION['active_tab']='home';*/

                    // Get remaining UserInfo values for user and store in session
                    //$_SESSION['address1'] = is_blank($user->getUserInfo()->getAddress()) ? 'N/A' : $user->getUserInfo()->getAddress();
                    //$_SESSION['postcode1'] = is_blank($user->getUserInfo()->getPostcode()) ? 'N/A' : $user->getUserInfo()->getPostcode();
                    //$_SESSION['civil_reg_number'] = is_blank($user->getUserInfo()->getCivilRegistrationNumber()) ? 'N/A' : $user->getUserInfo()->getCivilRegistrationNumber();
                    //$_SESSION['account_number'] = is_blank($user->getUserInfo()->getBankaccount()) ? 'N/A' : $user->getUserInfo()->getBankaccount();




                    redirect('/controller/profile.php', false); // SUCCESS: Redirect to profile user page
                    exit();
                }
                else{ //ERROR: passwords do not match or user is not validated
                    $data = $GLOBALS['twigdata'];
                    $data['username'] = $_POST['username'];
                    $data['message'] = 'Wrong username or password.';
                    $data['messageType'] = 'error';
                    echo $twig->render('index.twig', $data);
                }
            }

    }
    else{ //ERROR: no such a user.

        $data = $GLOBALS['twigdata'];
        $data['username'] = $_POST['username'];
        $data['message'] = 'Wrong username or password.';
        $data['messageType'] = 'error';
        echo $twig->render('index.twig', $data);
    }

}
/*
function make_path($local_url){
    if(!empty($GLOBALS['prj_dir'])){

        if(!startsWith($local_url, $GLOBALS['prj_dir'])){
            return $GLOBALS['prj_dir'].$local_url;
        }
    }
    return $local_url;
}

function startsWith($str, $prefix)
{
    $length = strlen($prefix);
    return (substr($str, 0, $length) === $prefix);
}
*/