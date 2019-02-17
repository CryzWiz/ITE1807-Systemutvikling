<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 16/02/2017
 * Time
/* initialize Propel, etc. */

require_once("../global_init.php");
require_once("../helper/su17_func.php");



echo "Hello World!<br>";
$all = ! isset($_GET['type']);

$timestamp = getTimestampAt();

$projects = new Propel\Runtime\Collection\ObjectCollection();
$teams = new Propel\Runtime\Collection\ObjectCollection();
$team_projects = new Propel\Runtime\Collection\ObjectCollection();
$users = new Propel\Runtime\Collection\ObjectCollection();
$user_teams = new Propel\Runtime\Collection\ObjectCollection();

$unames = array("user", "admin", "ola", "kari");

$users->setModel('User');
$projects->setModel('Project');
$team_projects->setModel('TeamProject');
$teams->setModel('Team');
$user_teams->setModel('UserTeam');





if($all){

    foreach($unames as $name){
        $users->append(UserQuery::create()->findOneByUsername($name));
    }
    //var_dump($users);
    echo "users ok<br>";
    echo "adding projects and teams for testing...<br>";


    for($i=1; $i<3; $i++ ) {
        $t = new Team();
        $t->setName('Time-Test-Team ' . $i);
        $teams->append($t);
    }
    //$teams->save();
    //echo "teams ok<br>";

    for($i=1; $i<5; $i++ ) {
        $r = $i % 2;
        $ut = new UserTeam();
        $ut->setTeam($teams[$r]);
        //echo $teams[$r] . "<br>";
        $ut->setUser($users[$i-1]);
        $ut->setIsteamleader($i<3);
        echo $ut."<br>";
        echo "<br><br>";


        $user_teams->append($ut);
    }
        //$user_teams->save();
        //echo "users ok<br>";


    for($i=1; $i<5; $i++ ) {
        $prj = new Project();
        $prj->setName('Time test project ' . $i);
        $prj->setStart(getTimestampAt(0));
        $prj->setEnd(getTimestampAt());
        $ss = WorkStatusQuery::create()->findPk('PRGRSS');
        $prj->setWorkStatus($ss);
        $projects->append($prj);
        $r = $i % 2;
        $tp = new TeamProject();
        $tp->setProject($prj);
        $tp->setTeam($teams[$r]);

        $team_projects->append($tp);

    }
    $user_teams->save();

    echo "4 test projects and 2 teams were added successfully<br>";



}

$tasks = new Propel\Runtime\Collection\ObjectCollection();
$tasks->setModel('Task');

$task_names = array('Design', 'Coding', 'Testing', 'Install');
if($all || $_GET['type']=='tasks'){


    for($i=0; $i<4; $i++){
        $day = -30;
        foreach($task_names as $name){
            $task  = new Task();
            $task->setName($name);
            $task->setStatusId('PRGRSS');

            $dat1 = DateTime::createFromFormat('U',getTimestampAt($day*3600*24));
            $dat1->setTime(0,0,0);
            $task->setStart($dat1->getTimestamp());
            //60 days
            $dat2 = DateTime::createFromFormat('U',getTimestampAt($dat1->getTimestamp(),60*24,true));
            $dat2->setTime(23,0,0);
            $task->setEnd($dat2->getTimestamp());
            $task->setPlannedhours(rand(2,10));
            $task->setTeamProject($team_projects[$i]);
            $tasks->append($task);

        }
    }

}
$tasks->save();
echo "4 tasks for every test project were added successfully<br>";

$time_regs = new Propel\Runtime\Collection\ObjectCollection();
$time_regs->setModel('TimeRegistration');
$test_date = new DateTime;

$allusers = UserQuery::create()->find();

foreach($allusers as $uuu) {
    $arr = array();
    $userteams = UserTeamQuery::create()->findByUserId($uuu->getId());
    foreach ($userteams as $uteam) {
        $tasks = TaskQuery::create()->findByTeamId($uteam->getTeamId());
        foreach ($tasks as $utask) {
            $obj = new stdClass();
            $obj->user_id = $uuu->getId();
            $obj->team_id = $uteam->getTeamId();
            $obj->task_id = $utask->getId();
            $obj->start = $utask->getStart();
            array_push($arr, $obj);
        }

        $d = rand(5, 15);
        $tim = getTimestampAt(0, -1 * $d * 24); //$d days before
        $dat1 = DateTime::createFromFormat('U', $tim);
        $dat1->setTime(7, 0, 0);
        $nextts = $dat1->getTimestamp();
        foreach ($arr as $row) {
            $tr = new TimeRegistration();
            $tr->setUserId($row->user_id);
            $tr->setTaskId($row->task_id);
            $tr->setTeamId($row->team_id);
            //!!!!!

            $tr->setStart($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $nexth = rand(1, 7);
            $nextts = getTimestampAt($nextts, $nexth, true);
            $tr->setStop($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $time_regs->append($tr);

            $nextd = rand(1, 7);
            $nextts = getTimestampAt($nextts, $nextd*24, true);



            $tr1 = new TimeRegistration();
            $tr1->setUserId($row->user_id);
            $tr1->setTaskId($row->task_id);
            $tr1->setTeamId($row->team_id);
            //!!!!!

            $tr1->setStart($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $nexth = rand(1, 7);
            $nextts = getTimestampAt($nextts, $nexth, true);
            $tr1->setStop($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $time_regs->append($tr1);

            $nextd = rand(1, 3);
            $nextts = getTimestampAt($nextts, $nextd*24, true);

            $tr2 = new TimeRegistration();
            $tr2->setUserId($row->user_id);
            $tr2->setTaskId($row->task_id);
            $tr2->setTeamId($row->team_id);
            //!!!!!

            $tr2->setStart($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $nexth = rand(5, 7);
            $nextts = getTimestampAt($nextts, $nexth, true);
            $tr2->setStop($nextts);

            $test_date->setTimestamp($nextts);
            echo $nextts . ' - ' . $test_date->format('Y-m-d H:i:s e') . '<br>';

            $time_regs->append($tr2);

            $nextd = rand(1, 3);
            $nextts = getTimestampAt($nextts, $nextd*24, true);
        }

    }

    $time_regs->save();
    echo "time registrations were added successfully<br>";

    echo "<br>done";
    echo "<br>Ready for Time Registration Testing !!!!";
    echo "<br>Propel is so easy!";
}




