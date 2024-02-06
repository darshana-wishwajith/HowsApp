<?php

    include "../includes/email/sending.php";

    if(isset($_POST["unverifiedEmail"])){

        if(!empty($_POST["unverifiedEmail"])){

            $unverified_email = $_POST["unverifiedEmail"];

            if(filter_var($unverified_email,FILTER_VALIDATE_EMAIL)){
                
                $vcode = random_int(100000, 999999);

                $email_content = "<p>Your email verification code is <b style='font-size: 20px'>".$vcode."</b></P>";
                
                $send_email = new Send("Email Verification", $email_content, $unverified_email );

                if(!$send_email){
                    echo("Verification code sending faild");
                }
                else{

                    setcookie("vcode", $vcode, time()+60*2);
                    echo("Verification code sent successfully! please check your email inbox.");
                }
                
            }
            else{
                echo("Invalid email address");
            }
        }
        else{
            echo("Please type your email before send the verification code");
        }
    }
    else{
        echo("Somthing went wrong. Please try again later");
    }
    
?>
