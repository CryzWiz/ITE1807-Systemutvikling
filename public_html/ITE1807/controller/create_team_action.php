<?php
/**
 * Created by PhpStorm.
 * User: vicki/christian
 * Date: 01/03/17
 * Time: 22:06
 */
session_start(); // Starting Session
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/DbTask.class.php");


$error2=false; // Variable To Store Error Message
$message2 = '';
$messageType2='';


if ( isset( $_POST['submit_pass'] ) ) { // REGISTER ATTEMPT
    /*
     * test invitation code is 'WELCOME27' should be set as event in stud_v17_gruppe1( with period 1 week ? )
     * nobody_id will be predefined id for invitation links
     * id in valid_link is foreign key which references id in user table
     */


    if ( empty( $_POST['password'] ) ) { // NO PASSWORD ENTERED
        $message2 .= "No password written! ";
        $error2 = true;

    } else {
        if ( empty( $_POST['password2'] ) ) { // NO SECOND PASSWORD ENTERED
            $message2 .= "No confirmed password written! ";
            $error2 = true;

        } elseif ( $_POST['password'] != $_POST['password2'] ) { // PASSWORD DOES NOT MATCH
            $message2 .= "Passwords does not match! ";
            $error2 = true;

        } elseif ( strlen( $_POST['password'] ) < 8 ) { // PASSWORD TOO SHORT
            $message2 .= "Password is to short. Minimum 8 characters! ";
            $error2 = true;

        }
    }
    if ( !$error2 ) { // NO ERRORS
        $password = getPasswordHash($_POST['password']);

        $user = UserQuery::create()->findOneById($_SESSION['user_id']);

        if($user != null)
        {
            $user->setPassword($password);
            $user->setPassExpiresAt(getTimestampAt());
            try{
                $count = $user->save();

                    echo $twig->render('profile.twig', array(
                        'message2' => 'Changes was saved.',
                        'messageType2' => 'success',
                        'active_tab' => 'userinfo'
                    ));

            }catch(Exception $e){
                echo $twig->render('profile.twig', array(
                    'message' => '',
                    'messageType' => '',
                    'message2' => $e->getMessage(),
                    'messageType2' => 'error',
                    'active_tab' => 'userinfo'
                ));
            }

        }
        else{ // user with the same username or email exists already in DB
            echo $twig->render('profile.twig', array(
                'message' => '',
                'messageType' => '',
                'message2' => 'Illegal operation.',
                'messageType2' => 'error',
                'active_tab' => 'userinfo'
            ));
        }

    }else { // THERE WERE ERRORS
        echo $twig->render('profile.twig', array(
            'message' => '',
            'messageType' => '',
            'message2' => $message2,
            'messageType2' => 'error',
            'active_tab' => 'userinfo'
        ));
    }

}
else {// NO SUBMIT
    echo $twig->render( 'profile.twig', array(
        'message' => '',
        'messageType' => '',
        'message2' => $message2,
        'messageType2' => 'warning',
        'active_tab' => 'userinfo'
    ) );

}


