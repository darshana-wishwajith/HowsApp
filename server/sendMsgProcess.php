<?php
    session_start();
    include "../includes/config.php";

    if ((!isset($_SESSION["user"]) || !isset($_SESSION["chat_user"])) || (empty($_SESSION["user"]) || empty($_SESSION["chat_user"]))) {

        echo ("Message send faild. Please try again later");

    } else{

        $from = $_SESSION["user"]["email"];
        $to = $_SESSION["chat_user"];

        if(!isset($_POST["msg"]) || empty($_POST["msg"])){
            echo("Message send faild. Please try again later");
        }
        else{
            $msg = $_POST["msg"];

            $msg_status = 2;

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date_time = $d->format("Y-m-d H:i:s");

            Database::insert_update_delete("INSERT INTO `message` (`content`, `date_time`, `from`, `to`, `msg_status_msg_s_id`) VALUES ('".$msg."', '".$date_time."', '".$from."', '".$to."', '".$msg_status."')");

            echo("success");
        }

    }
?>