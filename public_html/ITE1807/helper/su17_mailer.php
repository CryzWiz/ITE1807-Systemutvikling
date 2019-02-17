<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 21/02/2017
 * Time: 17:55
 */
use PHPMailer\PHPMailer\PHPMailer;
//Import PHPMailer classes into the global namespace
require_once( dirname(__DIR__, 3) . '/vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once(__DIR__ . '/su17_strings.php');
require_once(dirname(__DIR__, 1) . '/global_init.php');


function send_validation_mail($mailto, $fullname = ''){

    $mail = createMailer($mailto, $fullname = '');

    if($mail == null)
    { // only in debug mode, redirect to info.php with debug message
        //redirect($GLOBALS['prj_dir']."/controller/info.php?mdebug=".$mail->ErrorInfo); // Redirecting to info page
        echo $mail->ErrorInfo;

        return 2;
    }


    try{
        $mail->Subject = 'Valideringslink til Morild Data BA';
        $vlink = md5(time(). mt_rand(1, 1000000));

        $link = ValidLinkQuery::create()->findOneByValidlink($vlink);
        $user = UserQuery::create()->findOneByEmail($mailto);

        //not needed here? should be moved to test
        if($link != null || $user == null){

            return 1; // should not ever happen, check db design
        }
        $link = ValidLinkQuery::create()->findPk($user->getId());

        if($link == null){ //NO ACTIVE VALIDATION LINK FOR THIS USER, SO WE CREATE ONE
            $link = new ValidLink();
            $link->setId($user->getId());
        }
        echo $link->getId();
        $link->setValidlink($vlink);

        //CREATE OR UPDATE VALIDATION LINK
        $res = $link->save();
        if( $res == 0 ){ // valid link insertion or update failed
            return 102; //Error.
        }

        $mbody = "
                    <html lang=\"no\">
                        <head>
                            <style>
                                /* CSS is imported from bootstrap */
                                body {
                                    font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif;
                                    font-size: 14px;
                                    line-height: 1.42857143;
                                    color: #333;
                                }
                                html {
                                    font-size: 10px;
                                }
                                html {
                                    font-family: sans-serif;
                                    -webkit-text-size-adjust: 100%;
                                }
                                /*
                                * CSS for the nav
                                */
                                .container-fluid > .navbar-header, .container > .navbar-collapse, .container > .navbar-header {
                                    margin-right: 0;
                                    margin-left: 0;
                                }
                                .container-fluid > .navbar-collapse, .container-fluid > .navbar-header, .container > .navbar-collapse, .container > .navbar-header {
                                    margin-right: -15px;
                                    margin-left: -15px;
                                }
                                .navbar-header {
                                    float: left;
                                }
                                * {
                                    -webkit-box-sizing: border-box;
                                    -moz-box-sizing: border-box;
                                    box-sizing: border-box;
                                }
                                .navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
                                    margin-left: -15px;
                                }
                                .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a {
                                    text-shadow: 0 -1px 0 rgba(0,0,0,.25);
                                }
                                .navbar-inverse .navbar-brand {
                                    color: #9d9d9d;
                                }
                                .navbar-brand {
                                    padding-left: 40px;
                                }
                                .navbar-brand, .navbar-nav > li > a {
                                    text-shadow: 0 1px 0 rgba(255,255,255,.25);
                                }
                                .navbar-brand {
                                    float: left;
                                    height: 50px;
                                    padding: 15px 15px;
                                    font-size: 18px;
                                    line-height: 20px;
                                }
                                nav, section, summary {
                                    display: block;
                                }
                                .navbar-fixed-top {
                                    border: 0;
                                }
                                .navbar-fixed-bottom, .navbar-fixed-top, .navbar-static-top {
                                    border-radius: 0;
                                }
                                .navbar-inverse {
                                    background-image: -webkit-linear-gradient(top,#3c3c3c 0,#222 100%);
                                    background-image: -o-linear-gradient(top,#3c3c3c 0,#222 100%);
                                    background-image: -webkit-gradient(linear,left top,left bottom,from(#3c3c3c),to(#222));
                                    background-image: linear-gradient(to bottom,#3c3c3c 0,#222 100%);
                                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
                                    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
                                    background-repeat: repeat-x;
                                    border-radius: 4px;
                                }
                                .navbar-inverse {
                                    background-color: #222;
                                    border-color: #080808;
                                }
                                .navbar-fixed-top {
                                    top: 0;
                                    border-width: 0 0 1px;
                                }
                                .navbar-fixed-bottom, .navbar-fixed-top {
                                    border-radius: 0;
                                }
                                .navbar-fixed-bottom, .navbar-fixed-top {
                                    position: fixed;
                                    right: 0;
                                    left: 0;
                                    z-index: 1030;
                                }
                                .navbar {
                                    border-radius: 4px;
                                }
                                .navbar {
                                    position: relative;
                                    min-height: 50px;
                                    margin-bottom: 20px;
                                    border: 1px solid transparent;
                                }
                                .container-fluid {
                                    margin: 0px;
                                    padding: 0px;
                                }
                                .container-fluid {
                                    padding-right: 15px;
                                    padding-left: 15px;
                                    margin-right: auto;
                                    margin-left: auto;
                                }
                                a {
                                    color: #337ab7;
                                    text-decoration: none;
                                }
                                a {
                                    background-color: transparent;
                                }
                                /*
                                * CSS for wrapping container and offset (centering)
                                */
                                .col-md-offset-4 {
                                    margin-left: 33.33333333%;
                                }
                                .col-md-4 {
                                    width: 33.33333333%;
                                }
                                .col-md-4 {
                                    float: left;
                                    position: relative;
                                    min-height: 1px;
                                    padding-right: 15px;
                                    padding-left: 15px;
                                }
                                .main {
                                    min-height: 90vh;
                                }
                                /*
                                * CSS for the panel
                                */
                                .panel {
                                    margin-top: 80px;
                                }
                                .panel {
                                    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                                    box-shadow: 0 1px 2px rgba(0,0,0,.05);
                                }
                                .panel-primary {
                                    border-color: #337ab7;
                                }
                                .panel {
                                    margin-bottom: 20px;
                                    background-color: #fff;
                                    border: 1px solid;
                                    border-radius: 4px;
                                    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                                    box-shadow: 0 1px 1px rgba(0,0,0,.05);
                                }
                                .panel-primary > .panel-heading {
                                    background-image: -webkit-linear-gradient(top,#337ab7 0,#2e6da4 100%);
                                    background-image: -o-linear-gradient(top,#337ab7 0,#2e6da4 100%);
                                    background-image: -webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#2e6da4));
                                    background-image: linear-gradient(to bottom,#337ab7 0,#2e6da4 100%);
                                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff2e6da4', GradientType=0);
                                    background-repeat: repeat-x;
                                }
                                .panel-primary > .panel-heading {
                                    color: #fff;
                                    background-color: #337ab7;
                                    border-color: #337ab7;
                                }
                                .panel-heading {
                                    padding: 10px 15px;
                                    border-bottom: 1px solid transparent;
                                    border-top-left-radius: 3px;
                                    border-top-right-radius: 3px;
                                }
                                .panel-body {
                                    padding: 15px;
                                }

                            </style>

                        </head>
                        <body>
                            <nav class=\"navbar navbar-inverse navbar-fixed-top\">
                                <div class=\"container-fluid\">
                                    <div class=\"navbar-header\">
                                        <a class=\"navbar-brand\" href=\"{{ server_url }}/ITE1807/index.php\">Morild Data BA</a>
                                    </div>
                                </div>
                            </nav>
                            <div class=\"col-md-4 col-md-offset-4 main\">
                                <div class=\"panel panel-primary\">
                                    <div class=\"panel-heading\">Valideringslink</div>
                                      <div class=\"panel-body\">
                                        <p>Det har blitt registrert en konto hos Morild Data BA med denne eposten. Bekreft registreringen ved å følge denne linken:</p>
                                          <br>
                                          <br>
                                          <span style=\"text-align:center;display:block;\">
                                          <p><a href='" . $GLOBALS['server_url']. $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] ."/controller/validate.php?vlink=" . $vlink . "' >
                                          Valider din konto</a></p>
                                          </span>
                                          <br>
                                          <br>
                                          <p>Om du ikke har registrert deg hos Morild Data BA ber vi deg om å slette denne eposten.</p>
                                          <br>
                                          <br>
                                          <p>Hilsen Morild Data BA</p>

                                      </div>
                                </div>
                            </div>
                        </body>
                    </html>
                ";

        $mail->CharSet = 'UTF-8';
        $mail->msgHTML($mbody);


        //send the message, check for errors
        if(!$mail->Send()){
            if($mail->SMTPDebug < 1){  // error sending validation link
                return 2;
            }
            else{ // only in debug mode, redirect to info.php with debug message
                //redirect($GLOBALS['prj_dir']."/controller/info.php?mdebug=".$mail->ErrorInfo); // Redirecting to info page
                echo $GLOBALS['twig']->render( 'info.twig', array(
                    'message' => $mail->ErrorInfo
                ));

                exit();
            }
        }
        else{
            return 0; //SUCCESS
        }

    }
    catch(Exception $ex){
        return 2;
    }


}

function send_newpass_mail($mailto, $uid, $fullname = ''){

    try{
        $user = UserQuery::create()    //// trying to find user by email or username
        ->findOneByEmail($mailto);
        $mailpass = newPasssword();
        $pass = getPasswordHash($mailpass);
        $curr_timestamp = date('Y-m-d H:i:s');
        $timestamp = strtotime($curr_timestamp) + 60*60;
        $time = date('H:i', $timestamp);
        $user->setPassword($pass);
        $user->setPassExpiresAt($time);

        $mail = createMailer($mailto, $fullname = '');
        $mail->Subject = 'Nytt passord for Moril Data BA';
        $mbody = "
                <html lang=\"no\">
                <head>
                    <meta charset=\"utf-8\">
                    <style>
                        /* CSS is imported from bootstrap */
                        body {
                            font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.42857143;
                            color: #333;
                        }
                        html {
                            font-size: 10px;
                        }
                        html {
                            font-family: sans-serif;
                            -webkit-text-size-adjust: 100%;
                        }
                        /*
                        * CSS for the nav
                        */
                        .container-fluid > .navbar-header, .container > .navbar-collapse, .container > .navbar-header {
                            margin-right: 0;
                            margin-left: 0;
                        }
                        .container-fluid > .navbar-collapse, .container-fluid > .navbar-header, .container > .navbar-collapse, .container > .navbar-header {
                            margin-right: -15px;
                            margin-left: -15px;
                        }
                        .navbar-header {
                            float: left;
                        }
                        * {
                            -webkit-box-sizing: border-box;
                            -moz-box-sizing: border-box;
                            box-sizing: border-box;
                        }
                        .navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
                            margin-left: -15px;
                        }
                        .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a {
                            text-shadow: 0 -1px 0 rgba(0,0,0,.25);
                        }
                        .navbar-inverse .navbar-brand {
                            color: #9d9d9d;
                        }
                        .navbar-brand {
                            padding-left: 40px;
                        }
                        .navbar-brand, .navbar-nav > li > a {
                            text-shadow: 0 1px 0 rgba(255,255,255,.25);
                        }
                        .navbar-brand {
                            float: left;
                            height: 50px;
                            padding: 15px 15px;
                            font-size: 18px;
                            line-height: 20px;
                        }
                        nav, section, summary {
                            display: block;
                        }
                        .navbar-fixed-top {
                            border: 0;
                        }
                        .navbar-fixed-bottom, .navbar-fixed-top, .navbar-static-top {
                            border-radius: 0;
                        }
                        .navbar-inverse {
                            background-image: -webkit-linear-gradient(top,#3c3c3c 0,#222 100%);
                            background-image: -o-linear-gradient(top,#3c3c3c 0,#222 100%);
                            background-image: -webkit-gradient(linear,left top,left bottom,from(#3c3c3c),to(#222));
                            background-image: linear-gradient(to bottom,#3c3c3c 0,#222 100%);
                            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
                            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
                            background-repeat: repeat-x;
                            border-radius: 4px;
                        }
                        .navbar-inverse {
                            background-color: #222;
                            border-color: #080808;
                        }
                        .navbar-fixed-top {
                            top: 0;
                            border-width: 0 0 1px;
                        }
                        .navbar-fixed-bottom, .navbar-fixed-top {
                            border-radius: 0;
                        }
                        .navbar-fixed-bottom, .navbar-fixed-top {
                            position: fixed;
                            right: 0;
                            left: 0;
                            z-index: 1030;
                        }
                        .navbar {
                            border-radius: 4px;
                        }
                        .navbar {
                            position: relative;
                            min-height: 50px;
                            margin-bottom: 20px;
                            border: 1px solid transparent;
                        }
                        .container-fluid {
                            margin: 0px;
                            padding: 0px;
                        }
                        .container-fluid {
                            padding-right: 15px;
                            padding-left: 15px;
                            margin-right: auto;
                            margin-left: auto;
                        }
                        a {
                            color: #337ab7;
                            text-decoration: none;
                        }
                        a {
                            background-color: transparent;
                        }
                        /*
                        * CSS for wrapping container and offset (centering)
                        */
                        .col-md-offset-4 {
                            margin-left: 33.33333333%;
                        }
                        .col-md-4 {
                            width: 33.33333333%;
                        }
                        .col-md-4 {
                            float: left;
                            position: relative;
                            min-height: 1px;
                            padding-right: 15px;
                            padding-left: 15px;
                        }
                        .main {
                            min-height: 90vh;
                        }
                        /*
                        * CSS for the panel
                        */
                        .panel {
                            margin-top: 80px;
                        }
                        .panel {
                            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                            box-shadow: 0 1px 2px rgba(0,0,0,.05);
                        }
                        .panel-primary {
                            border-color: #337ab7;
                        }
                        .panel {
                            margin-bottom: 20px;
                            background-color: #fff;
                            border: 1px solid;
                            border-radius: 4px;
                            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                            box-shadow: 0 1px 1px rgba(0,0,0,.05);
                        }
                        .panel-primary > .panel-heading {
                            background-image: -webkit-linear-gradient(top,#337ab7 0,#2e6da4 100%);
                            background-image: -o-linear-gradient(top,#337ab7 0,#2e6da4 100%);
                            background-image: -webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#2e6da4));
                            background-image: linear-gradient(to bottom,#337ab7 0,#2e6da4 100%);
                            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff2e6da4', GradientType=0);
                            background-repeat: repeat-x;
                        }
                        .panel-primary > .panel-heading {
                            color: #fff;
                            background-color: #337ab7;
                            border-color: #337ab7;
                        }
                        .panel-heading {
                            padding: 10px 15px;
                            border-bottom: 1px solid transparent;
                            border-top-left-radius: 3px;
                            border-top-right-radius: 3px;
                        }
                        .panel-body {
                            padding: 15px;
                        }

                    </style>
                </head>
                <body>
                    <nav class=\"navbar navbar-inverse navbar-fixed-top\">
                        <div class=\"container-fluid\">
                            <div class=\"navbar-header\">
                                <a class=\"navbar-brand\" href=\"{{ server_url }}/ITE1807/index.php\">Morild Data BA</a>
                            </div>
                        </div>
                    </nav>
                    <div class=\"col-md-4 col-md-offset-4 main\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">Nytt Passord</div>
                              <div class=\"panel-body\">
                                <p>Det har blitt bedt om nytt passord for konto tilknyttet denne eposten. Du kan logge inn ved å bruke passord:</p>
                                  <br>
                                  <span style=\"text-align:center;display:block;color:blue\">$mailpass</span>
                                  <br>
                                  <br>
                                  <p>Husk å endre ditt passord så snart du er logget inn.</p>
                                  <br>
                                  <br>
                                  <p>Hilsen Morild Data BA</p>

                              </div>
                        </div>
                    </div>


                </body>
                </html>
            ";
        $mail->CharSet = 'UTF-8';
        $mail->msgHTML($mbody);

        //send the message, check for errors
        if(!$mail->Send()){
            if($mail->SMTPDebug < 1){  // error sending validation link
                return 2;
            }
            else{ //only in debug mode, redirect to info.php with debug message

                echo $GLOBALS['twig']->render( 'info.twig', array(
                    'message' => $mail->ErrorInfo
                ) );
            }
        }
        else{
            $user->save();
            return 0; //SUCCESS
        }

    }
    catch(Exception $ex){
        echo $ex->getMessage();
    }

    return 1;
}

function createMailer($mailto, $fullname = ''){
    $mail = null;

    try{
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "systemutvikling2017@gmail.com";
        $mail->Password = "epleogappelsin";
        $mail->setFrom('systemutvikling2017@gmail.com', 'noreply');
        $mail->addAddress($mailto, $fullname);
    }

    catch(Exception $ex){
        echo $ex->getMessage();
    }

    return $mail;

}






