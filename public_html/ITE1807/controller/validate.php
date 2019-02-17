<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 21/02/2017
 * Time: 18:48
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_strings.php");
require_once(dirname(__DIR__, 1) . "/helper/DbTask.class.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");

$template = $twig->load('info.twig');
$vlink = $_GET['vlink'];



if( !empty($vlink)) { // vlink parameter was supplied.
    $link = ValidLinkQuery::create()->filterByCreatedAt(array('min' => getTimestampAt(-3600)))
                                    ->findOneByValidlink($vlink);

    if(!empty($link)){

        $user = UserQuery::create()->findPk($link->getId());
        if(!empty($user)){
            if($user->getValidated() == false){
                //ok. user was found.
                //just set validation to true and delete validation link.
                //TODO: log should be written with date & userid.
                $res = DbTask::ValidateLink($user->getEmail(), $vlink);
                if( $res == 0){
                    $message = $GLOBALS['SU17_INFO_MESSAGES'][3];
                }
                else {
                    $message = $GLOBALS['SU17_INFO_MESSAGES'][$res];
                }

            }
            else{
                //attempt to validate already va
                //lidated email.
                $message = $GLOBALS['SU17_INFO_MESSAGES'][4];
            }
        }else{
            //TODO: critical error. table valid_link contains id of non existent user.
            // Should not ever happen. Check DB design.
            $message = $GLOBALS['SU17_INFO_MESSAGES'][4];
        }

    }
    else{
        //wrong validation link.
        //validation link was not found in table valid_link.
        $message = $GLOBALS['SU17_INFO_MESSAGES'][5];
    }

}
else {
    //TODO: should be changed
    //validate.php called without vlink parameter.
    $message = "vlink not supplied";
}


//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
$data['message'] = $message;
$data['page_title'] = 'Profile';
$data['isPrivate'] = false;
$data['role'] = "";

echo $template->render($data);