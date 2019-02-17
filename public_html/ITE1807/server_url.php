<?php
$srv_path = is_localhost() ? 'localhost' :'kark.uit.no';
$user_dir = is_localhost() ? '' : '/~aar029';
$prj_dir = is_localhost() ? '/sysutv2017/public_html/ITE1807' : '/ITE1807';

function is_localhost() {
    $localhost = array( '127.0.0.1', '::1', 'localhost' );
    if( in_array( $_SERVER['REMOTE_ADDR'], $localhost) )
        return true;
}