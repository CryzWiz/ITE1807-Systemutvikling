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
$template = $twig->load('report/report_team.twig');

//Here we@ll set up all needed variables for template/page
$data = $GLOBALS['twigdata'];
//var_dump($data);
$data['page_title'] = 'Rapportering';
$data['isPrivate'] = false;
$data['role'] = "";

$user = UserQuery::create()->findPk($_SESSION['user_id']);
$teams = $user->getTeamsForTeamleaderRoleAsArray();
$data['report_teams'] = $teams;

if(isset($_POST['report_time'])){
    $data['report_time'] = $_POST['report_time'];
}
else{
    $data['report_time'] ='FIRSTOFMONTH-TODAY';
}
if(isset($_POST['report_team'])){
    $data['report_team'] = $_POST['report_team'];
}
else{
    $data['report_team'] = -1;
}
$dates = mb_split("-",$data['report_time']);
$url_date_from = $dates[0];
$url_date_to = $dates[1];
$print_url='';
$xml_url='';
if($data['report_team'] == -1){
    $print_url = sprintf('execute_mode=EXECUTE&project=sysutv2017_report&xmlin=%s&leader_id=4&RANGE1_DATEFROM=%s&RANGE1_DATETO=%s&target_format=%s',
        'report_all.xml', $url_date_from, $url_date_to, 'PDF');
    $xml_url = sprintf('execute_mode=EXECUTE&project=sysutv2017_report&xmlin=%s&leader_id=4&RANGE1_DATEFROM=%s&RANGE1_DATETO=%s&target_format=%s',
        'report_all.xml', $url_date_from, $url_date_to, 'XML');
}
else{
    $print_url = sprintf('execute_mode=EXECUTE&project=sysutv2017_report&xmlin=%s&leader_id=4&RANGE1_DATEFROM=%s&RANGE1_DATETO=%s&TeamId=%s&target_format=%s',
        'report_team.xml', $url_date_from, $url_date_to, $data['report_team'], 'PDF');
    $xml_url = sprintf('execute_mode=EXECUTE&project=sysutv2017_report&xmlin=%s&leader_id=4&RANGE1_DATEFROM=%s&RANGE1_DATETO=%s&TeamId=%s&target_format=%s',
        'report_team.xml', $url_date_from, $url_date_to, $data['report_team'], 'XML');
}

$data['print_url'] = $print_url;
$data['xml_url'] = $xml_url;
//$print_url =
/*echo $data['report_time'];
echo '<br>';
echo $data['report_team'];
echo '<br>';*/
echo $template->render($data);