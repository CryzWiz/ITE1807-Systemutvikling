<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class HoursExDTO implements Serializable
{
    public $id;
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
    public $PredefinedTask;
    public $Comment;
    public $Approved;
    public $Active;
    public $TotalSeconds;

    public function __construct(){

    }

    public static function createHourDTO(int $id,
                                         int $User_id,
                                         int $Team_id,
                                         int  $Task_id,
                                         String $Start,
                                         String $Stop,
                                         String $Place,
                                         String $PredefinedTask,
                                         String $Comment,
                                         int $Approved,
                                         boolean $Active){

        $hourDTO = new HoursExDTO();
        $user = UserQuery::create()->findPk($User_id);
        $team = TeamQuery::create()->findPk($Team_id);
        $task = TaskQuery::create()->findPk($Task_id);
        $project = ProjectQuery::create()->findPk($task->getProjectId());
        $hourDTO->id = $id;
        $hourDTO->User_id = $User_id;
        $hourDTO->Fullname = ($user ? ($user->getFirstname().' ' . $user->getLastname()):'');
        $hourDTO->Team_id = $Team_id;
        $hourDTO->Team_name = ($team ? $team->getName(): '');
        $hourDTO->Task_id = $Task_id;
        $hourDTO->Team_name = ($task ? $task->getName() : '');
        $hourDTO->Project_name = ($project ? $project->getName() : '');
        $hourDTO->Start = $Start;
        $hourDTO->Stop = $Stop;
        $hourDTO->Place = $Place;
        $hourDTO->PredefinedTask = $PredefinedTask;
        $hourDTO->Comment = $Comment;
        $hourDTO->Approved = $Approved;
        $hourDTO->Active = $Active;
        return $hourDTO;
    }

    public static function create(TimeRegistration $hours){
        $hourDTO = new HoursExDTO();
        if($hours==null)
            return $hourDTO;

        $user = $hours->getUser();
        $team = $hours->getTeam();
        $task = $hours->getTask();
        $project = ProjectQuery::create()->findPk($task->getProjectId());

        $hourDTO->id = $hours->getId();
        $hourDTO->User_id = $hours->getUserId();
        $hourDTO->Fullname = ($user ? ($user->getFirstname().' ' . $user->getLastname()):'');
        $hourDTO->Team_id = $hours->getTeamId();
        $hourDTO->Team_name = TeamQuery::create()->findPk($hours->getTeamId())->getName();
        $hourDTO->Task_id = $hours->getTaskId();
        $hourDTO->Task_name = TaskQuery::create()->findPk($hours->getTaskId())->getName();
        $hourDTO->Start = $hours->getStart()? $hours->getStart()->format("Y-m-d H:i:s"): '';
        $hourDTO->Stop = $hours->getStop()? $hours->getStop()->format("Y-m-d H:i:s") : '';
        $hourDTO->Project_name = ($project ? $project->getName() : '');
        $hourDTO->Place = $hours->getPlace();
        $hourDTO->PredefinedTask = $hours->getPredefinedtask();
        $hourDTO->Comment = $hours->getComment();
        $hourDTO->Approved = $hours->getApproved();
        $hourDTO->Active = $hours->getActive();

        if($hours->getStart() && $hours->getStop()){
            $ti = $hours->getStop()->getTimestamp();
            $hours->getStart()->getTimestamp();
            $hourDTO->TotalSeconds = $ti;
        }

        return $hourDTO;
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

        $this->id = $data['id'];
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
        $this->PredefinedTask = $data['predefinedtask'];
        $this->Comment = $data['comment'];
        $this->Approved = $data['approved'];
        $this->Active = $data['active'];

    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
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
            'predefinedtask' => $this->PredefinedTask,
            'comment' => $this->Comment,
            'approved' => $this->Approved,
            'active' => $this->Active
        );

        return $result;
    }

    public static function getphpName(){ return 'HoursExDTO';}



}