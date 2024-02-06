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

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 vh-100">

                <?php
                include "header.php";
                $current_user = $_SESSION["user"];



                $friend_request_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $current_user["email"] . "' OR `to` = '" . $current_user["email"] . "') AND `friend_status_fs_id` = '1'");

                $friend_request_num = $friend_request_rs->num_rows;
                ?>

                <div class="row">
                    <div class="col-10 offset-1">
                        <h1 class="text-center fw-bolder mt-5">F R I E N D S</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-10 offset-1">
                        <div class="row mt-3 g-3">
                            <div class="col-8">
                                <input type="text" class="form-control" placeholder="Your friend's email..." id="friendSearch">
                            </div>
                            <div class="col-4 d-grid">
                                <button class="btn btn-primary" onclick="friendSearch();">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="friendSearchProfile">

                </div>

                <div class="row d-none" id="friendNotFound">
                    <div class="col-10 offset-1">
                        <div class="border rounded-3 p-4 mt-3">
                            <div class="text-center">
                                <i class="bi bi-search fs-1"></i>
                            </div>
                            <h3>Your friend not found in our system </h3>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-10 offset-1">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Friends</button>
                                <button class="nav-link position-relative" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">requests
                                    <?php
                                    if ($friend_request_num > 0) {
                                    ?>
                                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger me-5">
                                            <?php echo $friend_request_num ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </button>
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rejected</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                                <?php
                                $friends_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $current_user['email'] . "' OR `to` = '" . $current_user['email'] . "') AND (`friend_status_fs_id` = '1' OR `friend_status_fs_id` = '2')");

                                $friends_num = $friends_rs->num_rows;

                                if ($friends_num == 0) {

                                ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="border rounded-3 p-4">
                                                <h3>You have not any friend yet</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                } else {
                                    for ($i = 0; $i < $friends_num; $i++) {

                                        $friends_data = $friends_rs->fetch_assoc();
                                        $friend_satus = $friends_data["friend_status_fs_id"];

                                        if ($friends_data["to"] != $current_user["email"]) {

                                            $fprofile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $friends_data['to'] . "'");

                                            $fprofile_img_num = $fprofile_img_rs->num_rows;

                                            if ($fprofile_img_num == 1) {

                                                $fprofile_img_data = $fprofile_img_rs->fetch_assoc();

                                                $friend_user_rs = Database::search("SELECT * FROM `user` WHERE  `email` = '" . $friends_data["to"] . "'");

                                                $friend_user_data = $friend_user_rs->fetch_assoc();

                                                if ($friend_satus == 1) {
                                    ?>
                                                    <div class="col-12 mt-2">
                                                        <div class="border rounded-3 p-2">
                                                            <div class="row">
                                                                <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                    <img src="<?php echo $fprofile_img_data['path'] ?>" width="40px" class=" rounded-circle">
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="row">
                                                                        <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                        <div class="border rounded-3 p-2">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <img src="<?php echo $fprofile_img_data['path'] ?>" width="40px" class=" rounded-circle">
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="row">
                                                                        <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <span class="badge rounded-pill text-bg-success">friends</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {

                                                $friend_user_rs = Database::search("SELECT * FROM `user` WHERE  `email` = '" . $friends_data["to"] . "'");

                                                $friend_user_data = $friend_user_rs->fetch_assoc();

                                                if ($friend_user_data["gender_gender_id"] == 1) {

                                                    if ($friend_satus == 1) {

                                                    ?>
                                                        <div class="col-12 mt-2">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                        <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php

                                                    } else if ($friend_satus == 2) {
                                                    ?>
                                                        <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-success">friends</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                } else {

                                                    if ($friend_satus == 1) {
                                                    ?>
                                                        <div class="col-12 mt-2">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                        <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php

                                                    } else if ($friend_satus == 2) {
                                                    ?>
                                                        <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-success">friends</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php

                                                    }
                                                }
                                            }
                                        } else {

                                            $fprofile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $friends_data['from'] . "'");

                                            $fprofile_img_num = $fprofile_img_rs->num_rows;

                                            if ($fprofile_img_num == 1) {
                                                $fprofile_img_data = $fprofile_img_rs->fetch_assoc();

                                                $friend_user_rs = Database::search("SELECT * FROM `user` WHERE  `email` = '" . $friends_data["from"] . "'");

                                                $friend_user_data = $friend_user_rs->fetch_assoc();

                                                if ($friend_satus == 1) {
                                                    ?>
                                                    <div class="col-12 mt-2">
                                                        <div class="border rounded-3 p-2">
                                                            <div class="row">
                                                                <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                    <img src="<?php echo $fprofile_img_data['path'] ?>" width="40px" class=" rounded-circle">
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="row">
                                                                        <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                        <div class="border rounded-3 p-2">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <img src="<?php echo $fprofile_img_data['path'] ?>" width="40px" class=" rounded-circle">
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="row">
                                                                        <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <span class="badge rounded-pill text-bg-success">friends</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                $friend_user_rs = Database::search("SELECT * FROM `user` WHERE  `email` = '" . $friends_data["from"] . "'");

                                                $friend_user_data = $friend_user_rs->fetch_assoc();

                                                if ($friend_user_data["gender_gender_id"] == 1) {

                                                    if ($friend_satus == 1) {

                                                    ?>
                                                        <div class="col-12 mt-2">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                        <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php


                                                    } else if ($friend_satus == 2) {
                                                    ?>
                                                        <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-success">friends</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php

                                                    }
                                                } else {

                                                    if ($friend_satus == 1) {
                                                    ?>
                                                        <div class="col-12 mt-2">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                                        <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-warning">pending</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php

                                                    } else if ($friend_satus == 2) {
                                                    ?>
                                                        <div class="col-12 mt-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                            <div class="border rounded-3 p-2">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="row">
                                                                            <span class="fw-bold"><?php echo $friend_user_data['fname'] . " " . $friend_user_data['lname'] ?></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <small class="fw-semibold"><?php echo $friend_user_data["email"] ?></small>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span class="badge rounded-pill text-bg-success">friends</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                <?php

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>

                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

                                <?php
                                $friends_rs2 = Database::search("SELECT * FROM `friend` WHERE `to` = '" . $current_user['email'] . "' AND `friend_status_fs_id` = '1' ");

                                $friends_num2 = $friends_rs2->num_rows;

                                if ($friends_num2 == 0) {
                                ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="border rounded-3 p-4">
                                                <h3>No friend requests</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {

                                    for ($j = 0; $j < $friends_num2; $j++) {


                                        $friends_data2 = $friends_rs2->fetch_assoc();
                                    ?>
                                        <div class="col-12 mt-2">
                                            <?php
                                            $friend_user_rs2 = Database::search("SELECT * FROM `user` WHERE `email` = '" . $friends_data2['from'] . "'");

                                            $friend_user_data2 = $friend_user_rs2->fetch_assoc();
                                            ?>
                                            <div class="border rounded-3 p-2">
                                                <div class="row">
                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                        <?php
                                                        $fprofile_img_rs2 = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $friends_data2['from'] . "'");

                                                        $fprofile_img_num2 = $fprofile_img_rs2->num_rows;

                                                        if ($fprofile_img_num2 == 1) {
                                                            $fprofile_img_data2 = $fprofile_img_rs2->fetch_assoc();

                                                        ?>
                                                            <img src="<?php echo $fprofile_img_data2['path'] ?>" width="40px" class=" rounded-circle">
                                                            <?php
                                                        } else {

                                                            if ($friend_user_data2['gender_gender_id'] == 1) {
                                                            ?>
                                                                <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="col-10">
                                                        <div class="row">
                                                            <span class="fw-bold"><?php echo $friend_user_data2['fname'] . " " . $friend_user_data2['lname'] ?></span>
                                                        </div>
                                                        <div class="row">
                                                            <small class="fw-semibold"><?php echo $friend_user_data2['email'] ?></small>
                                                        </div>
                                                        <div class="row d-flex justify-content-end mt-3 me-1">
                                                            <div class="col-4 col-md-2 d-grid">
                                                                <button class="btn btn-success" onclick="acceptFr('<?php echo  $friends_data2['friend_id'] ?>');">accept</button>
                                                            </div>
                                                            <div class="col-4 col-md-2 d-grid">
                                                                <button class="btn btn-danger" onclick="rejectFr('<?php echo  $friends_data2['friend_id'] ?>');">reject</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">

                                <?php
                                $friends_rs3 = Database::search("SELECT * FROM `friend` WHERE `from` = '" . $current_user['email'] . "' AND `friend_status_fs_id` = '3' ");

                                $friends_num3 = $friends_rs3->num_rows;

                                if ($friends_num3 == 0) {
                                ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="border rounded-3 p-4">
                                                <h3>Did not reject your any request yet</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {

                                    for ($k = 0; $k < $friends_num3; $k++) {


                                        $friends_data3 = $friends_rs3->fetch_assoc();
                                    ?>
                                        <div class="col-12 mt-2">
                                            <?php
                                            $friend_user_rs3 = Database::search("SELECT * FROM `user` WHERE `email` = '" . $friends_data3['to'] . "'");

                                            $friend_user_data3 = $friend_user_rs3->fetch_assoc();
                                            ?>
                                            <div class="border rounded-3 p-2">
                                                <div class="row">
                                                    <div class="col-2" onclick="gotoPublicProfile('<?php echo $friend_user_data['email']?>')">
                                                        <?php
                                                        $fprofile_img_rs3 = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $friends_data3['to'] . "'");

                                                        $fprofile_img_num3 = $fprofile_img_rs3->num_rows;

                                                        if ($fprofile_img_num3 == 1) {
                                                            $fprofile_img_data3 = $fprofile_img_rs3->fetch_assoc();

                                                        ?>
                                                            <img src="<?php echo $fprofile_img_data3['path'] ?>" width="40px" class=" rounded-circle">
                                                            <?php
                                                        } else {

                                                            if ($friend_user_data3['gender_gender_id'] == 1) {
                                                            ?>
                                                                <img src="resources/images/profile/sample_male.jpg" width="40px" class=" rounded-circle">
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <img src="resources/images/profile/sample_female.jpg" width="40px" class=" rounded-circle">
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="col-10">
                                                        <div class="row">
                                                            <span class="fw-bold"><?php echo $friend_user_data3['fname'] . " " . $friend_user_data3['lname'] ?></span>
                                                        </div>
                                                        <div class="row">
                                                            <small class="fw-semibold"><?php echo $friend_user_data3['email'] ?></small>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                            </div>
                                                        </div>
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