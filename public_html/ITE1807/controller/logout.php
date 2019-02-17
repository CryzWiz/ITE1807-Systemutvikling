<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 17/02/2017
 * Time: 18:46
 */
session_start();
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
if(session_destroy()) // Destroying All Sessions
{
    redirect('/index.php?logout=true'); // Redirecting To Home Page
    exit();
}
