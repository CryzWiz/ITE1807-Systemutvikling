<?php
/**
 * Created by PhpStorm.
 * User: Allan Arnesen
 * Date: 26.02.2017
 * Time: 03.12
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once dirname(__DIR__, 1) . "/helper/su17_func.php";
$template = $twig->load('404.twig');

//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
$data['page_title'] = 'ERROR';
$data['isPrivate'] = false;
$data['role'] = "";

echo $template->render($data);