<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 17/02/2017
 * Time: 00:25
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/DbTask.class.php");
session_start(); // Starting Session

$error=false; // Variable To Store Error Message

// Define $username and $password

$message = '';
$messageType='';


if ( isset( $_POST['submit'] ) ) { // REGISTER ATTEMPT
    /*
     * test invitation code is 'WELCOME27' should be set as event in stud_v17_gruppe1( with period 1 week ? )
     * id in valid_link is foreign key which references id in user table
     */

    $isPermanent = false;
    $permanent_invitation =  ValidLinkQuery::create()->findPk($permanent_vlink); // current invitation code
    $consult_invitation =  ValidLinkQuery::create()->findPk($consult_vlink); // current invitation code

    if ( !preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $_POST['invitation'] ) ) { // INVALID INVITATION (DO WE NEED THIS CHECK?)
        $message .= "Invitation code contains invalid characters! ";
        $error = true;
    }
    else {
        if ($_POST['invitation'] == $permanent_invitation->getValidlink()) { //PERMANENT INVITATION
            $isPermanent = true;
        }
        else if($_POST['invitation'] == $consult_invitation->getValidlink()) { //PERMANENT INVITATION
            $isPermanent = false;
        }
        else{//WRONG INVITATION
            $message .= "The invitation code is not valid.! ";
            $error = true;
        }
    }

    if ( empty( $_POST['username'] ) ) { // NO USERNAME ENTERED
        $username = $_POST['email'];
        $_POST['username'] = $_POST['email'];

    }
        if ( strlen( $_POST['username'] ) < 3) { // USERNAME.length() < 3
            $message .= "The username is too short. Minimum 3 characters! ";
            $error = true;
        }

        if ( strlen( $_POST['username'] ) >= 32) { // USERNAME.length() > 32
            $message .= "The username is too long. Maximum 32 characters! ";
            $error = true;
        }

        if ( !preg_match('/^[A-Za-z][A-Za-z0-9@.]*(?:_[A-Za-z0-9]+)*$/', $_POST['username'] ) ) { // INVALID USERNAME
                $message .= "Username contains invalid characters! ";
                $error = true;
            }


    if ( empty( $_POST['email'] ) ) { // NO EMAIL ENTERED
        $message .= "No email written! ";
        $error = true;

    } else {
        if ( !( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL )
            && preg_match('/@.+\./', $_POST['email'] ) ) ) { // EMAIL NOT VALID
            $message .= "Not a valid email! ";
            $error = true;

        }
    }

    if ( empty( $_POST['password'] ) ) { // NO PASSWORD ENTERED
        $message .= "No password written! ";
        $error = true;

    } else {
        if ( empty( $_POST['password2'] ) ) { // NO SECOND PASSWORD ENTERED
            $message .= "No confirmed password written! ";
            $error = true;

        } elseif ( $_POST['password'] != $_POST['password2'] ) { // PASSWORD DOES NOT MATCH
            $message .= "Passwords does not match! ";
            $error = true;

        } elseif ( strlen( $_POST['password'] ) < 8 ) { // PASSWORD TOO SHORT
            $message .= "Password is too short. Minimum 8 characters! ";
            $error = true;
        }
    }
    if ( !$error ) { // NO ERRORS
        $password = getPasswordHash($_POST['password']);
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];


        $user = UserQuery::create()->findOneByEmail($email);
        $user2 = UserQuery::create()->findOneByUsername($username);

        if($user == null && $user2 == null)
        {
            DbTask::CreateAccount($email, $username, $firstname, $lastname, $password, $isPermanent);
        }
        else{ // user with the same username or email exists already in DB
            echo $twig->render('register.twig', array(
                'user' => array(
                    'username' => $_POST['username'],
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email']
                ),
                'message' => 'Username or email is already taken',
                'messageType' => 'error'
            ));
        }

    }else { // THERE WERE ERRORS
        echo $twig->render('register.twig', array(
            'user' => array(
                'username' => $_POST['username'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email']
            ),
            'message' => $message,
            'messageType' => 'error'
        ));
    }

}
else {// NO SUBMIT
    echo $twig->render( 'register.twig', array(
        'user' => array(

        ),
        'message' => $message,
        'messageType' => 'warning'
    ) );

}
