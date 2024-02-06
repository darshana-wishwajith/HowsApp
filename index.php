<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Chat</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.css">
    <link rel="shortcut icon" href="resources/images/branding/logo.png" type="image/x-icon">
</head>

<body onload="chatLoader();">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 vh-100">

                <?php include "header.php";


                if (!isset($_SESSION["user"])) {

                    header("Location:login.php");
                } else {

                    $curent_user = $_SESSION["user"];

                    $friend_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $curent_user['email'] . "' OR `to` = '" . $curent_user['email'] . "') AND `friend_status_fs_id` = '2'");

                    $friend_num = $friend_rs->num_rows;

                ?>
                    <div class="row">
                        <div class="col-12">

                            <?php


                            if ($friend_num == 0) {
                            ?>
                                <div class="d-flex align-items-center justify-content-center" style="height:75vh">
                                    <h3 class="m-3">You have not any friend yet. Please to go friend page, search email of your friend, add and wait for acceptance.</h3>
                                </div>
                                <?php
                            } else {

                                for ($i = 0; $i < $friend_num; $i++) {

                                    $friend_data = $friend_rs->fetch_assoc();

                                    $friend_email;

                                    if ($friend_data['from'] == $curent_user['email']) {

                                        $friend_email = $friend_data["to"];
                                    } else {

                                        $friend_email = $friend_data["from"];
                                    }

                                    $msg_rs = Database::search("SELECT * FROM `message` WHERE (`from` = '" . $curent_user['email'] . "' AND `to` = '" . $friend_email . "') OR (`from` = '" . $friend_email . "' AND `to` = '" . $curent_user['email'] . "') ORDER BY `date_time` DESC");

                                    $msg_num = $msg_rs->num_rows;

                                    $last_msg;
                                    $date_time;
                                    $msg_status;

                                    if ($msg_num == 0) {
                                        $last_msg = "No Messages";

                                        $d = new DateTime();
                                        $tz = new DateTimeZone("Asia/Colombo");
                                        $d->setTimezone($tz);
                                        $date_time = $d->format("Y-m-d H:i:s");

                                        $msg_status = 4;
                                    } else {

                                        $msg_data = $msg_rs->fetch_assoc();
                                        $last_msg =  $msg_data['content'];
                                        $date_time = $msg_data['date_time'];
                                        $msg_status = $msg_data['msg_status_msg_s_id'];
                                        $to = $msg_data['to'];
                                    }

                                    $user_rs = Database::search("SELECT * FROM `user` LEFT JOIN `profile_img` ON user.email = profile_img.user_email INNER JOIN `gender` ON user.gender_gender_id = gender.gender_id WHERE user.email = '" . $friend_email . "'");

                                    $user_data = $user_rs->fetch_assoc();

                                    $gender = $user_data["gender_name"];

                                    $profile_img = $user_data["path"];

                                    $user_status = $user_data["user_status_us_id"];


                                    if ($msg_status == 4) {
                                ?>
                                        <div class="row bg-primary bg-gradient bg-opacity-25 py-3" onclick="viewInbox('<?php echo $friend_email ?>');">
                                        <?php
                                    } else if ($msg_status == 2 && $to == $curent_user["email"]) {
                                        ?>
                                            <div class="row bg-primary bg-gradient bg-opacity-75 py-3" onclick="viewInbox('<?php echo $friend_email ?>');">
                                            <?php
                                        } else if ($msg_status == 2 && $to != $curent_user["email"]) {
                                            ?>
                                                <div class="row bg-primary bg-gradient bg-opacity-25 py-3" onclick="viewInbox('<?php echo $friend_email ?>');">
                                                <?php
                                            }
                                                ?>
                                                <div class="col-3 text-center position-relative">

                                                    <?php
                                                    if ($user_status == 1) {

                                                        if ($profile_img != null) {
                                                    ?>
                                                            <img src="<?php echo $profile_img ?>" width="70px" class="rounded-circle">
                                                            <span class="position-absolute top-100 start-50 translate-middle p-2 bg-success border border-light rounded-circle">
                                                                <?php
                                                            } else {

                                                                if ($gender == "male") {
                                                                ?>
                                                                    <img src="resources/images/profile/sample_male.jpg" width="70px" class="rounded-circle">
                                                                    <span class="position-absolute top-100 start-50 translate-middle p-2 bg-success border border-light rounded-circle">
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <img src="resources/images/profile/sample_female.jpg" width="70px" class="rounded-circle">
                                                                        <span class="position-absolute top-100 start-50 translate-middle p-2 bg-success border border-light rounded-circle">
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                if ($profile_img != null) {
                                                                        ?>
                                                                        <img src="<?php echo $profile_img ?>" width="70px" class="rounded-circle">
                                                                        <span class="position-absolute top-100 start-50 translate-middle p-2 bg-secondary border border-light rounded-circle">
                                                                            <?php
                                                                        } else {

                                                                            if ($gender == "male") {
                                                                            ?>
                                                                                <img src="resources/images/profile/sample_male.jpg" width="70px" class="rounded-circle">
                                                                                <span class="position-absolute top-100 start-50 translate-middle p-2 bg-secondary border border-light rounded-circle">
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                    <img src="resources/images/profile/sample_female.jpg" width="70px" class="rounded-circle">
                                                                                    <span class="position-absolute top-100 start-50 translate-middle p-2 bg-secondary border border-light rounded-circle">
                                                                            <?php
                                                                            }
                                                                        }
                                                                    }
                                                                            ?>


                                                </div>
                                                <div class="col-6">
                                                    <span class="fw-bold"><?php echo $user_data['fname'] . " " . $user_data['lname'] ?></span><br>
                                                    <span class="fw-semibold"><?php echo $last_msg ?></span>
                                                </div>
                                                <div class="col-3 text-end">
                                                    <small class=" fw-semibold"><?php echo $date_time ?></small>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                }
                            }

                                ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <script src="script.js"></script>
        <script src="includes/bootstrap/bootstrap.js"></script>
        <script src="includes/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>