<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 18/02/2017
 * Time: 09:22
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");

//Use your test
$template = $twig->load('info.twig');

//Here we@ll set up all needed variables for template/page
$data = array();
$data['page_title'] = 'Register';
$data['project_title'] = $project_title;//
$data['project_path'] = $project_path;
$data['role'] = "";

echo $template->render($data);
