<?php
    include "../includes/config.php";
    if(!isset($_POST["email"])){
        echo("Something went wrong");
    }
    else{

        $email = $_POST["email"];

        $email_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."'");
        $email_num = $email_rs->num_rows;

        if($email_num == 1){
            echo("ok");
        }
        else{
            echo("no");
        }
    }
?>