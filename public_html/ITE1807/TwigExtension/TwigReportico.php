<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 17/04/17
 * Time: 14:34
 */

namespace ITE1807\TwigExtension;


class TwigReportico extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_Function('report_all', array($this, 'report_all')),
            new \Twig_Function('report_print_all', array($this, 'report_print_all')),
            new \Twig_Function('report_cvs_all', array($this, 'report_cvs_all')),
            new \Twig_Function('report_team', array($this, 'report_team')),
            new \Twig_Function('report_print_team', array($this, 'report_print_team')),
            new \Twig_Function('report_cvs_team', array($this, 'report_cvs_team'))
        );
    }
    public function report_all($leader_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_all.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "HTML";
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;

        return $q->execute();
    }
    public function report_print_all($leader_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_all.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "PDF";
        $q->pdf_delivery_mode = "INLINE"; //DOWNLOAD_NEW_WINDOW or DOWNLOAD_SAME_WINDOW or INLINE
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;

        return $q->execute();
    }
    public function report_cvs_all($leader_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_all.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "CVS";
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;


        return $q->execute();
    }

    public function report_team($leader_id, $team_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_team.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "HTML";
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;
        $q->initial_execution_parameters["TeamId"] = $team_id;

        return $q->execute();
    }
    public function report_print_team($leader_id, $team_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_team.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "PDF";
        $q->pdf_delivery_mode = "INLINE"; //DOWNLOAD_NEW_WINDOW or DOWNLOAD_SAME_WINDOW or INLINE
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;
        $q->initial_execution_parameters["TeamId"] = $team_id;

        return $q->execute();
    }
    public function report_cvs_team($leader_id, $team_id, $range)
    {
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/reportico.php');
        require_once($GLOBALS['public_path'] . '/ITE1807/reportico/extension/misc.php');
        $q = new \reportico();
        $q->initial_project = "sysutv2017_report";
        $q->initial_project_password = "123";
        $q->initial_report = "report_team.xml";
        $q->initial_execute_mode = "EXECUTE";
        $q->initial_output_format = "CVS";
        $q->access_mode = "REPORTOUTPUT";
        $q->embedded_report = true;
        $q->clear_reportico_session=true;
        $q->initial_execution_parameters = array();
        $q->initial_execution_parameters["leader_id"] = $leader_id;
        $q->initial_execution_parameters["RANGE1"] = $range;
        $q->initial_execution_parameters["TeamId"] = $team_id;
        /*$q->output_template_parameters["show_hide_prepare_section_boxes"] = "show";
        $q->output_template_parameters["show_hide_prepare_print_html_button"] = "show";
        $q->output_template_parameters["show_hide_prepare_csv_button"] = "show";
        $q->output_template_parameters["show_hide_navigation_menu"] = "show";
        $q->output_template_parameters["show_hide_dropdown_menu"] = "show";*/

        return $q->execute();
    }

}