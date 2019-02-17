<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class UserDTO implements Serializable
{
    public $id;
    public $fullname;
    public $fornavn;
    public $etternavn;
    public $email;
    public $isAdmin;
    public $isPermanent;
    public $isTeamleader;

    public function __construct(){

    }

    public static function create(User $user){
        $userDTO = new UserDTO();
        if($user==null)
            return $userDTO;

        $userDTO->id = $user->getId();
        $userDTO->fullname = $user->getFirstname().' '.$user->getLastname();
        $userDTO->fornavn = $user->getFirstname();
        $userDTO->etternavn = $user->getLastname();
        $userDTO->email = $user->getEmail();
        $userDTO->isPermanent = $user->isPermanent();
        $userDTO->isAdmin = $user->getRole() == $GLOBALS['role_admin'];
        $userDTO->isTeamleader = $user->isTeamleader();

        return $userDTO;
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
        $this->fullname = $data['fullname'];
        $this->fornavn = $data['fornavn'];
        $this->etternavn = $data['etternavn'];
        $this->email = $data['email'];
        $this->isPermanent = $data['isPermanent'];
        $this->isAdmin = $data['isAdmin'];
        $this->isTeamleader = $data['isTeamleader'];

    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
            'fullname' => $this->fullname,
            'fornavn' => $this->fornavn,
            'etternavn' => $this->etternavn,
            'email' => $this->email,
            'isPermanent' => $this->isPermanent,
            'isAdmin' => $this->isAdmin,
            'isTeamleader' => $this->isTeamleader
        );

        return $result;
    }

    public static function getphpName(){ return 'UserDTO';}



}