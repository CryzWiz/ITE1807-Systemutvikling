<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 18/02/2017
 * Time: 09:22
 */
require_once(__DIR__ . "/global_init.php");
$template = $twig->load('index.twig');

//variables for template/page
$data = $GLOBALS['twigdata'];
$data['page_title'] = 'Welcome';
$data['isPrivate'] = false;


echo $template->render($data);