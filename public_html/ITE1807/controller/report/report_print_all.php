<?php
/**
 * Created by PhpStorm.
 * User: Allan Arnesen
 * Date: 24.02.2017
 * Time: 10.30
 */
session_start();
require_once(dirname(__DIR__, 2) . "/global_init.php");
if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']))
{
    redirect('/index.php');
}

$template = $twig->load('report/report_team_print_all.twig');

//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
//var_dump($data);
$data['page_title'] = 'Rapportering';
$data['isPrivate'] = false;
$data['role'] = "";

echo $template->render($data);