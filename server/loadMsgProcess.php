<?php
session_start();
include "../includes/config.php";

if ((!isset($_SESSION["user"]) || !isset($_SESSION["chat_user"])) || (empty($_SESSION["user"]) || empty($_SESSION["chat_user"]))) {
    echo ("Somthing went wrong");
    header("Location: ../index.php");
} else {
    $current_user = $_SESSION["user"]["email"];
    $chat_user = $_SESSION["chat_user"];

    $msg_rs = Database::search("SELECT * FROM `message` WHERE (`from` = '" . $current_user . "' OR `to` = '" . $current_user . "') AND (`from` = '" . $chat_user . "' OR `to` = '" . $chat_user . "')");

    $msg_num = $msg_rs->num_rows;

    if ($msg_num == 0) {
?>
        <div class="d-flex align-items-center justify-content-center" style="height:75vh">
        <h3 class="m-3">No messages yet. Send your first message</h3>
        </div>
        <?php
    } else {

        $last_msg = false;

        for ($i = 0; $i < $msg_num; $i++) {

            if($i + 1 == $msg_num ){
                $last_msg = true;
            }
            
            $msg_data = $msg_rs->fetch_assoc();

            if ($msg_data['from'] == $current_user) {

        ?>
                <!--From msg-->
                <?php
                if($last_msg){
                    ?>  
                     <div class="row mb-5">
                    <?php
                }
                else{
                    ?>  
                    <div class="row">
                   <?php
                }
                ?>
               
                    <div class="from-msg d-flex justify-content-end">
                        <div class="col-9 bg-primary bg-gradient bg-opacity-50 rounded-4 my-3 shadow-lg">
                            <div class="row p-3">
                                <div class="col-12">
                                    <small class="text-start fw-semibold">Me</small>
                                </div>
                                <div class="col-12 py-1">
                                    <span class="fw-bold"><?php echo $msg_data['content'] ?></span>
                                </div>
                                <div class="col-12 text-end pt-2">
                                    <small class="fw-semibold"><?php echo $msg_data['date_time'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--From msg-->
            <?php

            } else {

                $chat_user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $msg_data['from'] . "'");

                $chat_user_data = $chat_user_rs->fetch_assoc();

            ?>
                <!--To msg-->
                <?php
                if($last_msg){
                    ?>  
                     <div class="row mb-5">
                    <?php
                }
                else{
                    ?>  
                    <div class="row">
                   <?php
                }
                ?>
                    <div class="to-msg d-flex justify-content-start">
                        <div class="col-9 bg-warning bg-gradient bg-opacity-25 rounded-4 my-3 shadow-lg">
                            <div class="row p-3">
                                <div class="col-12">
                                    <small class="text-start fw-semibold"><?php echo $chat_user_data["fname"]." ".$chat_user_data["lname"] ?></small>
                                </div>
                                <div class="col-12 py-1">
                                    <span class="fw-bold"><?php echo $msg_data['content'] ?></span>
                                </div>
                                <div class="col-12 text-end pt-2">
                                    <small class="fw-semibold"><?php echo $msg_data['date_time'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--To msg-->
<?php
            }
        }
    }
}
?>