<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class ProjectDTO implements Serializable
{
    public $id;
    public $name;
    public $start;
    public $end;
    public $statusId;
    public $status;

    public function __construct(){

    }

    public static function createUserDTO(int $id, string $name, string $start, string  $end, int $statusId, string $status){

        $prjDTO = new ProjectDTO();
        $prjDTO->id = $id;
        $prjDTO->name = $name;
        $prjDTO->start = $start;
        $prjDTO->end = $end;
        $prjDTO->statusId = $statusId;
        $prjDTO->status = $status;
        return $prjDTO;
    }

    public static function create(Project $project){
        $prjDTO = new ProjectDTO();
        if($project==null)
            return $prjDTO;

        $prjDTO->id = $project->getId();
        $prjDTO->name = $project->getName();
        $prjDTO->start = $project->getStart()->format("d/m/Y");
        $prjDTO->end = $project->getEnd()->format("d/m/Y");
        $prjDTO->statusId = $project->getStatusId();
        $prjDTO->status = WorkStatusQuery::create()->findPk($project->getStatusId())->getStatus();

        return $prjDTO;
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

    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
            'statusId' => $this->statusId,
            'status' => $this->status
        );

        return $result;
    }

    public static function getphpName(){ return 'ProjectDTO';}



}