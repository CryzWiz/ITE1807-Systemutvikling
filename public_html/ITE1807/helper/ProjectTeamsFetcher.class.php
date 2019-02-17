<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19.04.2017
 * Time: 01.33
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
class ProjectTeamsFetcher {
    public static function fetchProjectTeams($project_id) {
        $teams_on_project = array();
        $project_teams = TeamProjectQuery::create()->findByProjectId($project_id)->getColumnValues();
        for ($x = 0; $x < sizeof($project_teams); $x++) {
            array_push($teams_on_project, json_encode($project_teams));
        }
        for ($x = 0; $x < sizeof($teams_on_project); $x++) {
            $id = explode(',', $teams_on_project[$x]);
            $tempLeaders = UserTeamQuery::create()->joinWithUser()->findByTeamId($id);
        }
        for ($x = 0; $x < sizeof($tempLeaders); $x++) {
            if ($tempLeaders[$x]->getIsteamleader() == 1) {
                $team_name = TeamQuery::create()->findOneById($tempLeaders[$x]->getTeamId())->getName();
                $teamLeaders = UserQuery::create()->findOneById($tempLeaders[$x]->getUserId());
                $teamleader_name = $teamLeaders->getFirstname() . " " . $teamLeaders->getLastname();
                $teamleader_email = $teamLeaders->getEmail();
                $teamleader_holder[] = array("name" => $teamleader_name, "email" => $teamleader_email, "teamname" => $team_name);
            }
        }
        return $teamleader_holder;
    }
}