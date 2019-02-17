<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 12/03/2017
 * Time: 22:00
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");


class UserInfoDTO implements Serializable
{
    public $id;
    public $phone;
    public $mobile;
    public $address;
    public $postcode;
    public $personalnumber;
    public $bankkonto;

    public function __construct(){

    }

    public static function create(UserInfo $ui){
        $uiDTO = new UserInfoDTO();
        if($ui == null)
            return $uiDTO;

        $uiDTO->id = $ui->getUserId();
        $uiDTO->phone = $ui->getWorkPhone();
        $uiDTO->mobile = $ui->getMobilePhone();
        $uiDTO->address = $ui->getAddress();
        $uiDTO->postcode = $ui->getPostcode();
        $uiDTO->personalnumber = $ui->getCivilRegistrationNumber();
        $uiDTO->bankkonto = $ui->getBankaccount();

        return $uiDTO;
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
        $this->phone = $data['phone'];
        $this->mobile = $data['mobile'];
        $this->address = $data['address'];
        $this->postcode = $data['postcode'];
        $this->personalnumber = $data['personalnumber'];
        $this->bankkonto = $data['bankkonto'];

    }

    public function toArray()
    {

        $result = array(
            'id' => $this->id,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'personalnumber' => $this->personalnumber,
            'bankkonto' => $this->bankkonto
        );

        return $result;
    }

    public static function getphpName(){ return 'obj';}

}