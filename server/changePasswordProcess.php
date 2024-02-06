<?php
    include "../includes/config.php";

    if(!isset($_POST["email"]) || !isset($_POST["vcode"]) || !isset($_POST["newPassword"]) || !isset($_POST["rtPassword"])){
        echo("Something went wrong");
    }
    elseif(empty($_POST["newPassword"])){
        echo("Please enter a new password");
    }
    elseif(empty($_POST["rtPassword"])){
        echo("Please re-type the password");
    }
    else if($_POST["newPassword"] != $_POST["rtPassword"]){
        echo("New password and re-type password are  not matched");
    }
    else if(empty($_POST["vcode"])){
        echo("Please send a verfication code to your email and enter it on verification code field");
    }
    else if(!isset($_COOKIE['vcode'])){
        echo("Verification code is expired");
    }
    else if($_POST["vcode"] != $_COOKIE['vcode']){
        echo("Incorrect verification code");
    }
    else{

        $email = $_POST["email"];
        $password = $_POST["newPassword"];

        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."'");
        $user_num = $user_rs->num_rows;

        if($user_num == 1){
            Database::insert_update_delete("UPDATE `user` SET `password` = '".$password."' WHERE `email` = '".$email."'");

            echo("success");
        }
        else{
            echo("Incorrect email or an account does not exists with your email");
        }
    }
?>