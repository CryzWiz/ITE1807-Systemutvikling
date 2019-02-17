<?php
require_once(dirname(__DIR__, 1) . "/public_html/ITE1807/helper/HoursExDTO.class.php");
use Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
    /**
     * $role_admin = 2;
     * $role_user = 1;
     * $role_nobody = 3;
     */
    public function getHtmlRoleName(){
        switch($this->getRole()){

            case $GLOBALS['role_admin']:
                return 'admin';
            case $GLOBALS['role_user']:
                return 'user';
        }
        return 'nobody';
    }
    /**
     * Find teams were user is a teamleader.
     *
     * @return Propel\Runtime\Collection\ObjectCollection were user is teamleader
     */
    public function getTeamsForTeamleaderRole(){

        $teams = TeamQuery::create()
            ->useUserTeamQuery()
            ->filterByUser($this)
            ->filterByIsteamleader(true)
            ->endUse()
            ->find();

        return $teams;

    }
    /**
     * Find teams were user is a teamleader.
     *
     * @return array with array[<team.id>] = < team.Name> were user is a teamleader
     */
    public function getTeamsForTeamleaderRoleAsArray(){

        $ret =  array();

        foreach( $this->getTeamsForTeamleaderRole() as $team){
            $ret[$team->getId()]= $team->getName();
        }

        return $ret;
    }
    /**
     * Find teams were user is user or teamleader.
     *
     * @return Propel\Runtime\Collection\ObjectCollection were user is not teamleader
     */
    public function getTeamsForUserRole(){


            $teams = TeamQuery::create()
                ->useUserTeamQuery()
                ->filterByUser($this)
                //->filterByIsteamleader(false)
                ->endUse()
                ->find();

        return $teams;
    }
    /**
     * Find teams were user is uuser or teamleader.
     *
     * @return array with array[<team.id>] = < team.Name> were user is not teamleader
     */
    public function getTeamsForUserRoleAsArray(){

        $ret =  array();
        foreach( $this->getTeamsForUserRole() as $team){
            $ret[$team->getId()]= $team->getName();
        }

        return $ret;
    }
    /**
     * Find if user has leadership in any team.
     *
     * @return true if user has leadership in at least one team, or false if he hasn't
     */
    public function isTeamleader(){
        $userteams = $this->getTeamsForTeamleaderRole();
        return $userteams->count() > 0;
    }

    public function changePermanentById($id){
        $user = UserQuery::create()->findPk($id);

        try{
            if ($user->getPermanent()){
                $user->setPermanent(false);
                $message = "innleid";
            }
            else{
                $user->setPermanent(true);
                $message = "fast";
            }

            $user->save();

        }
        catch(\Propel\Runtime\Exception\PropelException $pe){
            $message = $pe;
        }
        return $message;

    }

    public function changeUserAccountStatusById($id){
        $user = UserQuery::create()->findPk($id);

        try{
            if ($user->getActive()){
                $user->setActive(false);
                $message = "inactive";
            }
            else{
                $user->setActive(true);
                $message = "active";
            }

            $user->save();

        }
        catch(\Propel\Runtime\Exception\PropelException $pe){
            $message = $pe;
        }
        return $message;

    }

    /**
     * Find all projects available for user.
     *
     * @return Propel\Runtime\Collection\ObjectCollection
     */
    public function getAllUserProjects(){

        $projects = ProjectQuery::create()
            ->useTeamProjectQuery()
            ->useTeamQuery()
            ->useUserTeamQuery()
            ->filterByUser($this)
            ->endUse()
            ->endUse()
            ->endUse()
            ->find();

        return $projects;
    }

    /**
     * Find last time registrations for user.
     *
     * @return array
     */
    public function getLastTimeRegistrations($count=4){

        $projects = array();
        $temp = TimeRegistrationQuery::create()
            ->filterByUser($this)
            ->orderByStart('DESC')
            ->limit($count)
            ->find();

        foreach($temp as $p){
            $prjDTO = HoursExDTO::create($p);
            array_push($projects, $prjDTO);
        }

        return $projects;
    }

}
