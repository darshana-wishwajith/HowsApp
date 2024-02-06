<?php
    session_start();
    include "../includes/config.php";

    if(!isset($_POST["toEmail"])){

        echo("somthing went wrong");
    }
    else{

        $from_mail = $_SESSION["user"]["email"];
        $to_mail = $_POST["toEmail"];
        $friend_status = '1';

        Database::insert_update_delete("INSERT INTO `friend` (`from`,`to`,`friend_status_fs_id`) VALUES ('".$from_mail."', '".$to_mail."', '".$friend_status."')");

        echo("success");

    }
?>