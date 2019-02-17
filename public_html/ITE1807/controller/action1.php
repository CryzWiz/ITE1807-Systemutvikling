<?php
/**
 * Created by PhpStorm.
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/UserDTO.class.php");
require_once(dirname(__DIR__, 1) . "/helper/UserInfoDTO.class.php");

session_start();

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']))
{
    redirect('/index.php');
}

$error = false; // flag used during input validation of user input
$message = "";

if(isset($_POST['submit'])) {

    $userinfo = UserInfoQuery::create()->findOneByUserId($_SESSION['user_id']);
    $user = UserQuery::create()->findOneByUsername($_SESSION['username']);

    //var_dump($user);
    //exit();

    $_SESSION['profileUpdateRequested'] = true; // used in profile.php to detect if a profile update request has been made

    //Checks the validity of input from user
    //TODO: Add better user input data checking
    if ( !is_blank($_POST['first_name']) )  {
        if (!preg_match('/^[a-åA-Å \-]+$/i', $_POST['first_name'])) { // check if invalid name
            $message .= "Oppdatering feilet: fornavn kan bare inneholde bokstaver, bindestrek og mellomrom! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['last_name']) )  {
        if (!preg_match('/^[a-åA-Å \-]+$/i', $_POST['last_name'])) { // check if invalid name
            $message .= "Oppdatering feilet: etternavn kan bare inneholde bokstaver og mellomrom! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['phone']) )  {
        if (!is_numeric($_POST['phone'])) { // check if invalid phone number
            $message .= "Oppdatering feilet: telenfonnummeret inneholder ikke-numeriske tegn! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['mobile']) )  {
        if ( !is_numeric($_POST['mobile']) ) { // check if invalid mobile phone number
            $message .= "Oppdatering feilet: mobilnummeret inneholder ikke-numeriske tegn! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['account_number']) )  {
        if ( !is_numeric($_POST['account_number']) ) { // check if invalid account number
            $message .= "Oppdatering feilet: kontonummeret inneholder ikke-numeriske tegn! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['civil_reg_number']) )  {
        if ( !is_numeric($_POST['civil_reg_number']) ) { // check if invalid civil registration number
            $message .= "Oppdatering feilet: fødselsnummeret inneholder ikke-numeriske tegn! ";
            $error = true;
        }
    }

    if ( !is_blank($_POST['address1']) ) {
        if (!preg_match('/^[a-åA-Å0-9 \-]+$/i', $_POST['address1'])) { // Check if invalid address
            $message .= "Oppdatering feilet: adressen inneholder ikke-alfanumeriske tegn! ";
            $error = true;
        }
    }

    if (is_blank($_POST['postcode1']) ) {
        $message .= "Postnummer er må fylles ut! ";
        $error = true;
    }
    else {
        if (!is_numeric($_POST['postcode1'])) { // Check if invalid postal code
            $message .= "Oppdatering feilet: postnummeret inneholder ikke-numeriske tegn! ";
            $error = true;
        } else if (!PostalQuery::create()->findOneByPostcode($_POST['postcode1'])) {  //Check if postal code exist in the postal table
            $message .= "Postnummeret er ikke gyldig! ";
            $error = true;
        }
    }

    if(!$error) {
        // All error checks passed, update UserInfo and User instance with new values
        $user->setFirstname($_POST['first_name']);
        $user->setLastname($_POST['last_name']);
        $userinfo->setWorkPhone($_POST['phone']);
        $userinfo->setMobilePhone($_POST['mobile']);
        $userinfo->setBankaccount($_POST['account_number']);
        $userinfo->setCivilRegistrationNumber($_POST['civil_reg_number']);
        $userinfo->setAddress($_POST['address1']);
        $postal = PostalQuery::create()->findOneByPostcode($_POST['postcode1']);
        $userinfo->setPostcode($postal->getPostcode());

        try {   // Try storing updated UserInfo and User instance data to db
            $user->save();
            $userinfo->save();
            $data = array(
                'messageType' => 'success',
                'message' => 'Brukerprofilen er blitt oppdatert.',
                'activeTab' => 'userinfo'
            );
            $_SESSION['profileUpdateData'] = $data;

            redirect('/controller/profile.php', false);
        }
        catch(Exception $e){
            var_dump($_POST);
            $data = array(
                'user_input' => array(
                    'firstname' => $_POST['first_name'],
                    'lastname' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'mobile' => $_POST['mobile'],
                    'phone' => $_POST['phone'],
                    'address1' => $_POST['address1'],
                    'postcode1' => $_POST['postcode1'],
                    'civil_reg_number' => $_POST['civil_reg_number'],
                    'account_number' => $_POST['account_number']),
                'message' => $e->getMessage(),
                'messageType' => 'error',
                'active_tab' => 'userinfo'
            );
        }
    }
    else { // User input contained illegal values, reload profile page with submitted values:
        $data['user_input'] = array(
            'firstname' => $_POST['first_name'],
            'lastname' => $_POST['last_name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'phone' => $_POST['phone'],
            'address1' => $_POST['address1'],
            'postcode1' => $_POST['postcode1'],
            'civil_reg_number' => $_POST['civil_reg_number'],
            'account_number' => $_POST['account_number']);
        $data['message'] = $message;
        $data['messageType'] = 'error';
        $data['active_tab'] = 'userinfo';
        $_SESSION['profileUpdateData'] = $data;

        redirect('/controller/profile.php', false);
    }
}
else {
    redirect("/index.php");
}




