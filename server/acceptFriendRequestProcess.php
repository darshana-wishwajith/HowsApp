<?php

    include "../includes/config.php";

    if(!isset($_POST['friendId'])){
        echo("something went wrong");
    }
    else if($_POST['friendId'] < 1){
        echo("Invalid friend request");
    }
    else if(empty($_POST['friendId'])){
        echo("Invalid friend request");
    }
    else{
        $friend_id = $_POST['friendId'];
        
        $friend_rs = Database::search("SELECT * FROM `friend` WHERE `friend_id` = '".$friend_id."'");

        $friend_num = $friend_rs->num_rows;

        if($friend_num == 1){

            Database::insert_update_delete("UPDATE `friend` SET `friend_status_fs_id` = '2' WHERE `friend_id` = '".$friend_id."' ");

            echo("success");
        }
        else{
            echo("Friend request acceptance faild. Please try again later");
        }
    }
?>