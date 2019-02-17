<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class ReportHourDTO implements Serializable
{
    public $User_id;
    public $Fullname;
    public $Team_id;
    public $Team_name;
    public $Task_id;
    public $Task_name;
    public $Project_name;
    public $Start;
    public $Stop;
    public $Place;
    public $Duration;

    public function __construct(){

    }

    public static function createFromArray($vals){

        $rhDTO = new ReportHourDTO();
        if(!$vals['User_id'] || !$vals['Team_id'] || !$vals['Task_id'] ||
            !$vals['Start'] || !$vals['Stop'] || !$vals['Duration'])
            return $rhDTO;
        //'User_id', 'Team_id', 'Task_id', 'StartPeriod', 'StopPeriod', 'Duration'
        $user = UserQuery::create()->findPk($vals['User_id']);
        $team = TeamQuery::create()->findPk($vals['Team_id']);
        $task = TaskQuery::create()->findPk($vals['Task_id']);
        $project = ProjectQuery::create()->findPk($task->getProjectId());
        $rhDTO->User_id = $vals['User_id'];
        $rhDTO->Fullname = ($user ? ($user->getFirstname().' ' . $user->getLastname()):'');
        $rhDTO->Team_id = $vals['Team_id'];
        $rhDTO->Team_name = ($team ? $team->getName(): '');
        $rhDTO->Task_id = $vals['Task_id'];
        $rhDTO->Task_name = TaskQuery::create()->findPk($vals['Task_id'])->getName();
        $rhDTO->Project_name = ($project ? $project->getName() : '');
        $rhDTO->Start = $vals['Start']; //? $vals['StartPeriod']->format("Y-m-d H:i:s"): '';
        $rhDTO->Stop = $vals['Stop']; // ? $vals['StopPeriod']->format("Y-m-d H:i:s"): '';
        $rhDTO->Duration = $vals['Duration'];
        return $rhDTO;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->User_id = $data['user_id'];
        $this->Fullname = $data['fullname'];
        $this->Team_id = $data['team_id'];
        $this->Team_name = $data['team_name'];
        $this->Task_id = $data['task_id'];
        $this->Task_name = $data['task_name'];
        $this->Project_name = $data['project_name'];
        $this->Start = $data['start'];
        $this->Stop = $data['stop'];
        $this->Place = $data['place'];
        $this->Duration = $data['duration'];

    }

    public function toArray()
    {

        $result = array(
            'user_id' => $this->User_id,
            'fullname' => $this->Fullname,
            'team_id' => $this->Team_id,
            'team_name' => $this->Team_name,
            'task_id' => $this->Task_id,
            'task_name' => $this->Task_name,
            'project_name' => $this->Project_name,
            'start' => $this->Start,
            'stop' => $this->Stop,
            'place' => $this->Place,
            'duration' => $this->Duration
        );

        return $result;
    }

    public static function getphpName(){ return 'ReportHourDTO';}



}