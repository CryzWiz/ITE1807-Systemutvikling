<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class TeamDTO implements Serializable
{
    public $id;
    public $name;

    public function __construct(){

    }

    public static function createTeamDTO(int $id, string $name){

        $teamDTO = new TeamDTO();
        $teamDTO->id = $id;
        $teamDTO->name = $name;
        return $teamDTO;
    }

    public static function create(Task $task){
        $teamDTO = new TeamDTO();
        if($task==null)
            return $teamDTO;

        $teamDTO->id = $task->getId();
        $teamDTO->name = $task->getName();
        return $teamDTO;
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
    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
            'name' => $this->name,
        );

        return $result;
    }

    public static function getphpName(){ return 'obj';}


}