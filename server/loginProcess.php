<?php
    session_start();
    include "../includes/config.php";

    if(!isset($_POST["email"]) || !isset($_POST["password"])){
        echo("Something went wrong");
    }
    else if(empty($_POST["email"])){
        echo("please enter your email");
    }
    else if(empty($_POST["password"])){
        echo("please enter your password");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."' AND `password` = '".$password."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){
        $user_data = $user_rs->fetch_assoc();
        $_SESSION['user'] = $user_data;
        echo("success");
    }
    else{
        echo("Incorrect email or password");
    }
?>