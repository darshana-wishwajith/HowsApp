<?php
    session_start();

    if(!isset($_POST["friendEmail"]) || empty($_POST["friendEmail"])){
        echo("Something went wrong");
    }
    else{

        if(isset($_SESSION['chat_user'])){
            $_SESSION["chat_user"] = null;
            $_SESSION["chat_user"] = $_POST["friendEmail"];
            echo("success");

        }else{
            $_SESSION["chat_user"] = $_POST["friendEmail"];
            echo("success");
        }
       
    }
?>