<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 16/02/2017
 * Time
/* initialize Propel, etc. */
//use Propel\Runtime\Propel;
//use Propel\Runtime\Collection\ObjectCollection;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

//include "../../../generated-classes/Base/TimeRegistration.php";
//include "../../../generated-classes/TimeRegistration.php";
require_once("../global_init.php");
require_once("../helper/su17_func.php");


/*include "../../../generated-classes/Base/Project.php";
include "../../../generated-classes/Base/ProjectQuery.php";
include "../../../generated-classes/Project.php";
include "../../../generated-classes/ProjectQuery.php";
include "../../../generated-classes/Map/ProjectTableMap.php";*/

echo "Hello World!<br>";
$all = ! isset($_GET['type']);

$timestamp = getTimestampAt();
if($all || $_GET['type']=='user'){
    echo "adding predefined users...<br>";
    $user = new User();
    $user->setFirstname("Kari");
    $user->setLastname("Nordman");
    $user->setEmail("v@m.com");
    $user->setPassword(getPasswordHash('123'));
    $user->setUsername("kari");
    $user->setValidated(true);
    $user->setUserInfo(new UserInfo());
    $user->setPassExpiresAt($timestamp);
    $user->setRole($role_nobody);
    $user->save();


    echo "user ok<br>";


    $user2 = new User();
    $user2->setFirstname("Ola");
    $user2->setLastname("Nordmann");
    $user2->setEmail("a@m.com");
    $user2->setPassword(getPasswordHash('123'));
    $user2->setUsername("ola");
    $user2->setRole($role_nobody);
    $user2->setValidated(true);
    $user2->setUserInfo(new UserInfo());
    $user2->setPassExpiresAt($timestamp);
    $user2->save();
    echo "user2 ok<br>";

    $user3 = new User();
    $user3->setFirstname("Admin");
    $user3->setLastname("Admin");
    $user3->setEmail("admin@m.com");
    $user3->setPassword(getPasswordHash('123'));
    $user3->setUsername("admin");
    $user3->setRole($role_admin);
    $user3->setValidated(true);
    $user3->setUserInfo(new UserInfo());
    $user3->setPassExpiresAt($timestamp);
    $user3->save();
    echo "user3 ok<br>";

    $user4 = new User();
    $user4->setFirstname("User");
    $user4->setLastname("User");
    $user4->setEmail("user@m.com");
    $user4->setPassword(getPasswordHash('123'));
    $user4->setUsername("user");
    $user4->setRole($role_user);
    $user4->setValidated(true);
    $user4->setUserInfo(new UserInfo());
    $user4->setPassExpiresAt($timestamp);
    $user4->save();
    echo "user4 ok<br>";


    $vlink = new ValidLink();
    $vlink->setId($permanent_vlink);
    $vlink->setValidlink('WELCOME27');
    $vlink->save();

    $vlink = new ValidLink();
    $vlink->setId($consult_vlink);
    $vlink->setValidlink('WELCOME_INNLEID');
    $vlink->save();

}

if(!$all && $_GET['type']=='link'){
    \Base\ValidLinkQuery::create()->find()->delete();
    $vlink = new ValidLink();
    $vlink->setId($permanent_vlink);
    $vlink->setValidlink('WELCOME27');
    $vlink->save();

    $vlink = new ValidLink();
    $vlink->setId($consult_vlink);
    $vlink->setValidlink('WELCOME_INNLEID');
    $vlink->save();
}

if($all || $_GET['type']=='project'){

    WorkStatusQuery::create()->deleteAll();
    $stats = new Propel\Runtime\Collection\ObjectCollection();
    $stats->setModel('WorkStatus');
    $s1 = new WorkStatus();
    $s1->setId('PRGRSS');
    $s1->setStatus('In Progress');
    $stats->append($s1);

    $s2 = new WorkStatus();
    $s2->setId('FINISH');
    $s2->setStatus('Finished');
    $stats->append($s2);

    $s3 = new WorkStatus();
    $s3->setId('ONHOLD');
    $s3->setStatus('On Hold');
    $stats->append($s3);

    $stats->save(); //saving all 4 rows to db

    echo "project...<br>";

    $prj = new Project();
    $prj->setName('Test project 1');
    $prj->setStart(getTimestampAt(0));
    $prj->setEnd(getTimestampAt());
    $ss = WorkStatusQuery::create()->findPk('PRGRSS');
    $prj->setWorkStatus($ss);
    $prj->save();

    echo "project ok<br>";


}

if($all || $_GET['type']=='team'){

    $prj = \Base\ProjectQuery::create()->findOneByName('Test Project 1');
    echo "project query ok<br>";
    $user = UserQuery::create()->findOneByUsername('user');
    echo "user query ok<br>";
    $tp = new TeamProject();
    $tp->setProject($prj);

    $ut = new UserTeam();
    $ut->setUser($user);
    $ut->setIsteamleader(true);
    $team = new Team();
    $team->setName('Dream Team');
    $team->addTeamProject($tp);
    $team->addUserTeam($ut);
    $team->save();

    $task = new Task();
    $task->setName('Project1 - test task');
    $task->setTeamProject($tp);
    $task->setStatusId('PRGRSS');
    $task->setStart(getTimestampAt(0));
    $task->setEnd(getTimestampAt());
    $task->save();

    $task = new Task();
    $task->setName('Project1 - second test task');
    $task->setTeamProject($tp);
    $task->setStatusId('PRGRSS');
    $task->setStart(getTimestampAt(3600*24));
    $task->setEnd(getTimestampAt(3600*24*5));
    $task->save();




}
/*
if($all || $_GET['type']=='time'){

    $task = TaskQuery::create()->findOneByName('Project1 - test task');
    $user = UserQuery::create()->findOneByUsername('user');

    $timeReg = new TimeRegistration();
    $timeReg->setUser($user);
    $timeReg->setTask($task);
    $timeReg->setStart('2017-03-28 08:00:00');
    $timeReg->setStop('2017-03-28 15:30:00');
    $timeReg->setPredefinedtask('Kontor');
    $timeReg->setComment('feed propel ææææ');
    $timeReg->setTeamId($task->getTeamId());
    $timeReg->save();

}
*/

echo "<br>done";
echo "<br>Propel is so easy!";


