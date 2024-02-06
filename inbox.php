<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Inbox</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.css">
    <link rel="shortcut icon" href="resources/images/branding/logo.png" type="image/x-icon">
</head>

<body onload="loader();">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-6 offset-md-3">
                <?php include "header.php";

                

                if ((!isset($_SESSION["user"]) || !isset($_SESSION["chat_user"])) || (empty($_SESSION["chat_user"]) || empty($_SESSION["user"]))) {

                    header("Location:login.php");
                } else {

                    $curent_user = $_SESSION["user"]["email"];
                    $chat_user = $_SESSION["chat_user"];


                    $msg_rs = Database::search("SELECT * FROM `message` WHERE (`from` = '" . $curent_user . "' OR `to` = '" . $curent_user . "') AND (`from` = '" . $chat_user . "' OR `to` = '" . $chat_user . "') ORDER BY `date_time` DESC");

                    $msg_num = $msg_rs->num_rows;

                    if($msg_num != 0){
                        $msg_data= $msg_rs->fetch_assoc();

                        if($msg_data["to"] == $curent_user){
                            Database::insert_update_delete("UPDATE `message` SET `msg_status_msg_s_id` = '4' WHERE `msg_id` = '".$msg_data['msg_id']."'");
                        }
                    }


                    $user_rs = Database::search("SELECT * FROM `user` LEFT JOIN `profile_img` ON user.email = profile_img.user_email INNER JOIN `gender` ON user.gender_gender_id = gender.gender_id WHERE user.email = '" . $chat_user . "'");

                    $user_data = $user_rs->fetch_assoc();

                    $profile_img = $user_data["path"];
                    $gender = $user_data["gender_name"];
                    $user_status = $user_data["user_status_us_id"];
                }
                ?>
                <div class="row sticky-top">
                    <div class="col-12">
                        <div class="row bg-primary bg-gradient py-2" onclick="gotoPublicProfile('<?php echo $user_data['email']?>');">
                            <div class="col-3 text-center position-relative">
                                <?php
                                if ($user_status == 1) {
                                    if ($profile_img != null) {
                                ?>
                                        <img src="<?php echo $profile_img ?>" width="50px" class=" rounded-circle">
                                        <span class="position-absolute top-100 start-50 translate-middle p-1 bg-success border border-light rounded-circle">
                                            <?php
                                        } else {
                                            if ($gender == "male") {
                                            ?>
                                                <img src="resources/images/profile/sample_male.jpg" width="50px" class=" rounded-circle">
                                                <span class="position-absolute top-100 start-50 translate-middle p-1 bg-success border border-light rounded-circle">
                                        <?php
                                            } else {
                                                ?>
                                                <img src="resources/images/profile/sample_female.jpg" width="50px" class=" rounded-circle">
                                                <span class="position-absolute top-100 start-50 translate-middle p-1 bg-success border border-light rounded-circle">
                                        <?php
                                            }
                                        }
                                    } else {
                                        if ($profile_img != null) {
                                            ?>
                                                    <img src="<?php echo $profile_img ?>" width="50px" class=" rounded-circle">
                                                    <span class="position-absolute top-100 start-50 translate-middle p-1 bg-secondary border border-light rounded-circle">
                                                        <?php
                                                    } else {
                                                        if ($gender == "male") {
                                                        ?>
                                                            <img src="resources/images/profile/sample_male.jpg" width="50px" class=" rounded-circle">
                                                            <span class="position-absolute top-100 start-50 translate-middle p-1 bg-secondary border border-light rounded-circle">
                                                    <?php
                                                        } else {
                                                            ?>
                                                            <img src="resources/images/profile/sample_female.jpg" width="50px" class=" rounded-circle">
                                                            <span class="position-absolute top-100 start-50 translate-middle p-1 bg-secondary border border-light rounded-circle">
                                                    <?php
                                                        }
                                                    }
                                    }
                                        ?>

                            </div>
                            <div class="col-9 text-start">
                                <span class="fw-bold"><?php echo $user_data['fname']." ".$user_data['lname']?></span><br>
                                <span class="fw-semibold text-dark text-opacity-75"><?php echo $user_data["email"]?></span>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="msg-container">
                    
                    <!-- Messages load to here -->
                    <span style="margin-left: 40%; margin-top:60%" id="inboxSpinner"></span>
                    
                </div>

                <div class="row fixed-bottom bg-light py-2">
                    <div class="col-10 offset-1 col-md-6 offset-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="sendMsg" placeholder="Type a message...">
                            <button class="btn btn-primary px-4" onclick="sendMsg();"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="includes/bootstrap/bootstrap.js"></script>
    <script src="includes/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>