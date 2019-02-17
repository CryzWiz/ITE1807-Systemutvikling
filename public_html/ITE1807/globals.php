<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 28/02/17
 * Time: 14:07
 */
require_once("server_url.php");
/////// Global variables ////////////////////

$public_path = dirname( __DIR__,1);
$project_path = dirname($public_path, 1 );
$protocol = 'http://';
$server_url = $protocol . $srv_path;

$doc_root = $protocol . $srv_path;
$template_path = $public_path . "/ITE1807/template";
$project_title = 'Systemutvikling 2017';

//user roles
$role_admin = 2;
$role_user = 1;
$role_nobody = 3;
// ids for use with welcome links
$permanent_vlink = 1;
$consult_vlink = 2;

$twigdata = array();
$twigdata['server_url'] = $GLOBALS['server_url'] . $GLOBALS['user_dir'];
$twigdata['assets_dir'] = $GLOBALS['server_url'] . $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/assets';
$twigdata['action_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . '/controller/';
$twigdata['isPrivate'] = false;
$twigdata['active_tab']='home';
