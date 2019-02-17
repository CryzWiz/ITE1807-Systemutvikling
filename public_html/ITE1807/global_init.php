<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 18/02/2017
 * Time: 14:44
 *
 *
 * Global variables (project constants, paths, osv)
 *
 */

////////// PATHs //////////////////////
require_once("globals.php");

/////// Initialization block /////////////////////
require_once($project_path . '/vendor/autoload.php');
require_once($public_path . '/ITE1807/TwigExtension/TwigReportico.php');
// setup Propel
require_once($project_path . '/generated-conf/config.php');

$loader = new Twig_Loader_Filesystem($template_path);

$twig = new Twig_Environment($loader, array(
    /*'cache' => 'cache',*/ // We will uncomment this when all templates will be ready to use
    'debug' => true
));

$twig->addFilter( new Twig_SimpleFilter('cast_to_array', function ($stdClassObject) {
    $response = array();
    foreach ($stdClassObject as $key => $value) {
        $response[] = array($key, $value);
    }
    return $response;
}));

$twig->addExtension(new \ITE1807\TwigExtension\TwigReportico());

if(!isset($_SESSION)){
    $_SESSION  = null;
}

$twig->addGlobal('session', $_SESSION);


