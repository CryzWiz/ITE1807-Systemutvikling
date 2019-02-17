<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class TaskDTO implements Serializable
{
    public $id;
    public $name;
    public $start;
    public $end;
    public $hours;
    public $dependentId;
    public $statusId;
    public $status;

    public function __construct(){

    }


    public static function create(Task $task){
        $taskDTO = new TaskDTO();
        if($task==null)
            return $taskDTO;

        $taskDTO->id = $task->getId();
        $taskDTO->name = $task->getName();
        $taskDTO->start = ($task->getStart() ? $task->getStart()->format("d/m/Y"): '');
        $taskDTO->end = ($task->getEnd() ? $task->getEnd()->format("d/m/Y"): '');
        $taskDTO->statusId = $task->getStatusId();
        $taskDTO->hours = $task->getPlannedhours();
        $taskDTO->dependentId = $task->getDependentId();
        $taskDTO->status = WorkStatusQuery::create()->findPk($task->getStatusId())->getStatus();

        return $taskDTO;
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
        $this->name = $data['name'];
        $this->start = $data['start'];
        $this->end = $data['end'];
        $this->statusId = $data['statusId'];
        $this->status = $data['status'];
        $this->dependentId = $data['dependentId'];
        $this->hours = $data['hours'];


    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
            'statusId' => $this->statusId,
            'status' => $this->status,
            'dependentId' => $this->dependentId,
            'hours' => $this->hours

        );

        return $result;
    }

    public static function getphpName(){ return 'obj';}


}