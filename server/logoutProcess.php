<?php
    session_start();

    if(isset($_SESSION["user"])){
        session_destroy();
        $_SESSION["user"] = null;
        echo("success");
    }
    else{
        echo("success");
    }
?>