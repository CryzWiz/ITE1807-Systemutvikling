<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class HoursDTO implements Serializable
{
    public $id;
    public $User_id;
    public $Team_id;
    public $Task_id;
    public $Start;
    public $Stop;
    public $Place;
    public $PredefinedTask;
    public $Comment;
    public $Approved;
    public $Active;

    public function __construct(){

    }

    public static function createHourDTO($id,
                                         $User_id,
                                         $Team_id,
                                         $Task_id,
                                         $Start,
                                         $Stop,
                                         $Place,
                                         $PredefinedTask,
                                         $Comment,
                                         $Approved,
                                         $Active){

        $hourDTO = new HoursDTO();
        $hourDTO->id = $id;
        $hourDTO->User_id = $User_id;
        $hourDTO->Team_id = $Team_id;
        $hourDTO->Task_id = $Task_id;
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
        $hourDTO = new HoursDTO();
        if($hours==null)
            return $hourDTO;

        $hourDTO->id = $hours->getId();
        $hourDTO->User_id = $hours->getUserId();
        $hourDTO->Team_id = $hours->getTeamId();
        $hourDTO->Task_id = $hours->getTaskId();
        $hourDTO->Start = $hours->getStart()? $hours->getStart()->format("Y-m-d H:i:s"): '';
        $hourDTO->Stop = $hours->getStop()? $hours->getStop()->format("Y-m-d H:i:s") : '';
        $hourDTO->Place = $hours->getPlace();
        $hourDTO->PredefinedTask = $hours->getPredefinedtask();
        $hourDTO->Comment = $hours->getComment();
        $hourDTO->Approved = $hours->getApproved();
        $hourDTO->Active = $hours->getActive();

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
        $this->Team_id = $data['team_id'];
        $this->Task_id = $data['task_id'];
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
            'team_id' => $this->Team_id,
            'task_id' => $this->Task_id,
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

    public static function getphpName(){ return 'HoursDTO';}



}