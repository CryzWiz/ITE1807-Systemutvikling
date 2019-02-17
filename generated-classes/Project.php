<?php

use Base\Project as BaseProject;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for representing a row from the 'project' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Project extends BaseProject
{
    public static function CreateProject($name, $start, $end, $teamId, $customerName, $customerAddress, $customerContactPerson, $customerEmail){

        $con = Propel::getWriteConnection(\Map\ProjectTableMap::DATABASE_NAME);

        $project = new Project();

        $message ="";

        if($customerName == '' || $customerAddress == '' || $customerContactPerson == '' || $customerEmail == ''){
            $message = "error";
            return $message;
        }
        else{
            $projectInfo = new ProjectInfo();
            $projectInfo->setCostumername($customerName);
            $projectInfo->setAddress($customerAddress);
            $projectInfo->setContactperson($customerContactPerson);
            $projectInfo->setEmail($customerEmail);
            $project->setProjectInfo($projectInfo);
        }

        if ($name == ''){
            $message = "error";

        }
        else{
            $project->setName($name);
        }
        if($start != ''){
            $start_date = strtr($start, '/','-');
            $start_date =  date("Y-m-d H:i:s", strtotime($start_date));
            $project->setStart($start_date);

        }
        else{
            $message = "error";
        }
        if($end != ''){
            $end_date = strtr($end, '/','-');
            $end_date =  date("Y-m-d H:i:s", strtotime($end_date));
            $project->setEnd($end_date);
        }
        else{
            $message = "error";

        }
        //setting default value for progress when creating a new project
        //if ($start)
        $project->setStatusId("PRGRSS");


        $con->beginTransaction();

        if($project->save() != 0){
            $con->commit();
            $message = "true";
        }
        else{
            $message = "error";
        }
        for ($x = 0; $x < sizeof($teamId); $x++) {
            $team = TeamQuery::create()->findPk(intval($teamId[$x]));
            $tp = new TeamProject();
            $tp->setProject($project);
            $team->addTeamProject($tp);
            $team->save();
        }

        return $message;
    }

    public static function UpdateProject($id, $newName, $newStart, $newEnd, $newStatus, $selectedTeams){
        $changedTeams = false;
        $message= "";
        $con = Propel::getWriteConnection(\Map\ProjectTableMap::DATABASE_NAME);
        $project = ProjectQuery::create()->findPk($id);
        $projectTeams = TeamProjectQuery::create()->filterByProjectId($id)->find();

        //echo($projectTeams);
        $projectTeamsArray = array();
        $selectedTeamsArray = explode(',', $selectedTeams);

        //var_dump($selectedTeamsArray);

        for($x = 0; $x < sizeof($projectTeams); $x++){
            $projectTeamsArray[$x] = $projectTeams[$x]->getTeamId();
        }
        // andding new relations
        for ($x = 0; $x < sizeof($selectedTeamsArray); $x++){
            if (in_array($selectedTeamsArray[$x],$projectTeamsArray)){
                //echo ' is already in array, doing nothing  '.PHP_EOL;
            }
            else{
                //echo ' not in array, adding new relation from DB  '.PHP_EOL;
                $team = TeamQuery::create()->findPk(intval($selectedTeamsArray[$x]));
                $tp = new TeamProject();
                $tp->setProject($project);
                $team->addTeamProject($tp);
                $team->save();
                $changedTeams = true;
                //$message += " " . $team->getName(). " er lagt til prosjektet";

            }
        }

        // removing teams if necessary
        for ($x = 0; $x < sizeof($projectTeamsArray); $x++){
            if (!in_array($projectTeamsArray[$x],$selectedTeamsArray)){
                //echo ' team was removed. removing relation team project  '.PHP_EOL;
                $team = TeamQuery::create()->findPk($projectTeamsArray[$x]);
                $tp = new TeamProject();
                //$tp = TeamProjectQuery::create()->findByTeamId($projectTeamsArray[$x]);
                //$tp->setProject($project);
                $team->removeTeamProject($tp);
                $team->save();
            }
            else{
                //echo ' team is in array, doing nothing '.PHP_EOL;
            }
        }

        if($project != null){
            if ($newName != ''){
                $project->setName($newName);
            }else{
                $message = "false, vennlig fyll inn prosjektnavn!";
            }

            if ($newStart != ''){
                $newStart = strtr($newStart, '/','-');
                $newStart = date("Y-m-d H:i:s", strtotime($newStart));
                $project->setStart($newStart);
            }else{
                $message = "false, vennlig fyll inn startdato!";
            }

            if($newEnd != ''){
                $newEnd = strtr($newEnd, '/','-');
                $newEnd =  date("Y-m-d H:i:s", strtotime($newEnd));
                $project->setEnd($newEnd);
            }else{
                $message = "false, vennlig fyll inn sluttdato!";
            }

            $project->setStatusId($newStatus);

            $con->beginTransaction();

            if($project->save() != 0){
                $con->commit();
                $message = "true";
            }else{
                if($changedTeams)
                    $message = "team er lagt til prosjektet";
                else
                    $message = "OBS!!! ingen ny informasjon er registrert...";
            }

        }
        else{
            $message = "false, fant ikke prosjektet i databasen...";
        }
        return $message;

    }

    public static function DeleteProject($id){
        $message = "";
        try{
            TeamProjectQuery::create()->findByProjectId($id)->delete();
            ProjectQuery::create()->findPk($id)->delete();
            $message ="true";
        }
        catch (\Propel\Runtime\Exception\PropelException $pe){
            $message = $pe->getMessage();

        }finally{
            return $message;
        }
    }

}
