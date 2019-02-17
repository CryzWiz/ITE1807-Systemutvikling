<?php
require_once(dirname(__DIR__, 1) . "/public_html/ITE1807/helper/ProjectDTO.class.php");
use Base\ProjectQuery as BaseProjectQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'project' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ProjectQuery extends BaseProjectQuery
{

    /**
     * Find projects for specified team id.
     *
     * @return array with each element is ProjectDTO
     */
    public static function getProjectsDTOByTeamId(int $id) : array {

        $ret =  array();
        //$projects = ProjectQuery::create()->joinWithTeamProject()->findById($id);
        $projects = ProjectQuery::create()->useTeamProjectQuery()->filterByTeamId($id)->endUse()->find();
            //findByProjectId($id)
        foreach( $projects as $prj){
            $p = ProjectDTO::create($prj);
            array_push($ret, $p);
        }

        return $ret;
    }

}
