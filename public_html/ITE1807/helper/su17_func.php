<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 20/02/2017
 * Time: 18:00
 */

include_once(dirname(__DIR__, 1) . "/globals.php");

function redirect($url, $permanent = false, $statusCode = 303, $out=false)
{
   // echo $GLOBALS['server_url'] . $url;
    if($out){
        echo $GLOBALS['server_url'].$url;
        exit();
    }

    header('Location: ' . $GLOBALS['server_url']. $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . $url, $permanent, $statusCode);
    die();
}

function is_blank($value) {
    return empty($value) && !is_numeric($value);
}

function getPasswordHash($password){

    return password_hash( $password, PASSWORD_DEFAULT );
}

function checkPassword($password, $hash){

    return password_verify($password, $hash);
}
function newPasssword(){

    return rand_passwd();
}

function getTimestampAt($timestamp = 31536000, $durationInHours = 0, $from_timestamp=false){
    // returns unix timestamp (the number of seconds since January 1 1970 00:00:00 UTC)
    // NOTE: 31536000 is amount of seconds in 365 days
    // getTimestamp() - returns unix timestamp after 1 year(365 days)
    // getTimestamp(0) - returns unix timestamp now
    // getTimestamp(0, 1) - returns unix timestamp in 1 hour
    // getTimestamp(0, -1) - returns unix timestamp 1 hour before now
    // getTimestamp(3600, 1) - returns unix timestamp in 2 hours
    // getTimestamp(3600, 1, true) - returns unix timestamp in 1 hour after given $timestamp

    $start_timestamp = strtotime(date('Y-m-d H:i:s')); //timestamp now (seconds)
    if($from_timestamp)
        $start_timestamp =  $timestamp; // start (seconds )
    else
        $start_timestamp +=  $timestamp; // now (seconds ) + $timestamp (seconds)
    $time = $start_timestamp + $durationInHours*3600;
    return $time;
}

function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
    return substr( str_shuffle( $chars ), 0, $length );
}
/*
 * Solution taken from:
 *
 * http://stackoverflow.com/questions/965611/forcing-access-to-php-incomplete-class-object-properties
 */
function fixObject (&$object)
{
    if (!is_object ($object) && gettype ($object) == 'object')
        return ($object = unserialize (serialize ($object)));
    return $object;
}


function getParamFromQueryString($str, $key){
    $arr = explode('&',$str);
    if(count($arr)>0)
        foreach($arr as $a){
            $keyvals = explode('=',$a);
            if(count($keyvals)>0 && $keyvals[0] == $key)
                return (count($keyvals)>1)? $keyvals[1] : '';
        }
    else{
        $keyvals = explode('=',$arr);
        if(count($keyvals)>0 && $keyvals[0] == $key)
            return (count($keyvals)>1)? $keyvals[1] : '';
    }
    return '';
}
