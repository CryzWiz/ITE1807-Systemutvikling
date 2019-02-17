<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 18/02/2017
 * Time: 09:22
 */

//require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(__DIR__ . "/global_init.php");

$template = $twig->load('index.twig');

//variables for template/page
$data = array();
$data['page_title'] = 'Welcome';
$data['project_title'] = $project_title;
$data['project_path'] = $public_path;
$data['server_url'] = $GLOBALS['server_url'];
$data['action_dir']= $GLOBALS['prj_dir'];
$data['isPrivate'] = false;

echo $template->render($data);