<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 21/02/2017
 * Time: 18:48
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
include(dirname(__DIR__, 1) . "/helper/su17_strings.php");
include(dirname(__DIR__, 1) . "/helper/su17_func.php");

$template = $twig->load('info.twig');

    if( isset($_GET['mdebug'])){

        if(!empty($mdebug)){

            $message=$mdebug;
        }
        else{
            //TODO: should be changed
            $message="NO ERRORINFO";
        }


    }
    else if (isset($_GET['msid'])){
        if(!is_blank($_GET['msid']) && !empty($SU17_INFO_MESSAGES[$_GET['msid']])) {
            $message = $SU17_INFO_MESSAGES[$_GET['msid']];
        }
        else{
            //TODO: should be changed
            $message="NO MESSAGEINFO";
        }
    }

    else{
        //TODO: should be changed
        $message = "info.php called without parameters.";
    }

//Here we@ll set up all needed variables for template/page
$data = array();
$data['message'] = $message;
$data['page_title'] = 'Information';
$data['project_title'] = $project_title;//
$data['project_path'] = $project_path;
$data['server_url'] = $server_url;
$data['isPrivate'] = false;
$data['role'] = "";

echo $template->render($data);