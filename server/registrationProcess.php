<?php

    include "../includes/config.php";
    
    if(!isset($_POST["fname"]) || !isset($_POST["lname"]) || !isset($_POST["genderSelector"]) || !isset($_POST["RegistrationMail"]) || !isset($_POST["vcode"]) ||  !isset($_POST["RegistrationPass"])) {

        echo("Something went wrong");

    }else if(empty($_POST["fname"])){
        
        echo("Please enter your first name");

    }else if(strlen($_POST["fname"]) > 45){

        echo("First name must less than 45 characters");

    }else if(empty($_POST["lname"])){
        
        echo("Please enter your lirst name");

    }else if(strlen($_POST["lname"]) > 45){

        echo("Last name must less than 45 characters");

    }else if(empty($_POST["RegistrationMail"])){
        
        echo("Please enter your email address");

    }else if(strlen($_POST["RegistrationMail"]) > 100){

        echo("Email must less than 100 characters");

    }
    else if(!filter_var($_POST["RegistrationMail"],FILTER_VALIDATE_EMAIL)){

        echo("Invalid email address");
    }
    else if(empty($_POST["vcode"])){
        
        echo("Please send a verfication code to your email and enter it on verification code field");

    }else if(strlen($_POST["vcode"]) > 6){

        echo("Verification code must includes 6 digits only");

    }
    else if(empty($_POST["RegistrationPass"])){
        
        echo("Please enter a password");

    }else if(strlen($_POST["RegistrationPass"]) < 5 || strlen($_POST["RegistrationPass"]) > 20){

        echo("Password must includes 5 to 20 characters");

    }
    else if(!isset($_COOKIE['vcode'])){
        echo("Email verification code is expired");
    }
    else if(($_COOKIE['vcode']) != $_POST["vcode"]){
        echo("Incorrect email verification code");
    }
    else{

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $gender = $_POST["genderSelector"];
        $email = $_POST["RegistrationMail"];
        $password = $_POST["RegistrationPass"];

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $status = "1";

        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."'");
        $user_num = $user_rs->num_rows;
        if($user_num != 0){
            echo("An account Already exists with your email");
        }
        else{
            Database::insert_update_delete("INSERT INTO `user` (`email`, `fname`, `lname`, `password`, `registration_date_time`, `gender_gender_id`, `user_status_us_id`) VALUES ('".$email."', '".$fname."', '".$lname."', '".$password."', '".$date."', '".$gender."', '".$status."')");

            echo("success");
        }


        
    }

    
?>
