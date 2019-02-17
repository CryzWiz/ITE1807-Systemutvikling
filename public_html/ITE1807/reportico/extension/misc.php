<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 13/04/17
 * Time: 19:10
 */

/**
 * Function formats seconds to working hours
 *
 */
function format_date_interval($seconds, $format)
{
    $d1 = new DateTime();
    $d2 = new DateTime();
    $d2->add(new DateInterval('PT'.$seconds.'S'));

    $interval = $d2->diff($d1);
    $d = 0;
    if($interval->days>0)
        $d=$interval->days;

    if($format === 'hhh'){
        $hh = $d*24 + $interval->h;
        $interval->h = $hh;
        return $interval->format("%H:%I:%S");
    }

    return date_interval_format($interval, $format);
}

/**
 * Function formats seconds to working hours
 *
 */
function get_overtime_seconds($seconds)
{
    $over = (int)$seconds - 27000;
    return ($over > 0)? $over : 0;
}