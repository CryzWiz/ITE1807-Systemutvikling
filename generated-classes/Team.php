<?php

use Base\Team as BaseTeam;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for representing a row from the 'team' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Team extends BaseTeam
{
    /**
     * Find all ordinary members of team.
     *
     * @return ObjectCollection of all team members except teamleader
     */
    public function getUsers(){
        $users = UserQuery::create()
            ->filterByActive(true) //only active users
            ->useUserTeamQuery()
            ->filterByTeam($this)
            ->filterByIsteamleader(false) //all users exept teamleader
            ->endUse()
            ->find();

        return $users;
    }
    /**
     * Find all members of team.
     *
     * @return ObjectCollection of all team members including teamleader
     */
    public function getAllUsers(){
        $users = UserQuery::create()
            ->filterByActive(true) //only active users
            ->useUserTeamQuery()
            ->filterByTeam($this)
            ->endUse()
            ->find();

        return $users;
    }

    public static function CreateTeam($name){

        $con = Propel::getWriteConnection(\Map\TeamTableMap::DATABASE_NAME);
        $team = new Team();

        //setting default value for progress when creating a new project
        //if ($start)
        $team->setName($name);

        $con->beginTransaction();

        if($team->save() != 0)
            $con->commit();

        return $team;

    }

    public static function DeleteTeam($id){
        $message = "";
        try{
            TeamQuery::create()->findPk($id)->delete();
            $message ="true";
        }
        catch (\Propel\Runtime\Exception\PropelException $pe){
            $message = $pe.$message;

        }finally{
            return $message;
        }
    }


}
