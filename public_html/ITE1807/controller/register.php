 <?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 18/02/2017
 * Time: 09:22
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once dirname(__DIR__, 1) . "/helper/su17_func.php";
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/UserInfoDTO.class.php");

$generalTemplate = $twig->load('generalTemplate.twig');

$template = $twig->load('register.twig');

//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
$data['page_title'] = 'Register';
$data['messageType'] = '';
$data['isPrivate'] = false;
$data['message'] = '';
//$data['role'] = '';

$generalTemplate->render($data);
echo $template->render($data);
