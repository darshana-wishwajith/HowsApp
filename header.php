<?php
session_start();
include_once "includes/config.php";

$current_user = $_SESSION["user"]["email"];

$friend_request_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $current_user . "' OR `to` = '" . $current_user . "') AND `friend_status_fs_id` = '1'");

$friend_request_num = $friend_request_rs->num_rows;
?>

<div class="row bg-gradient bg-success bg-opacity-25 py-3">
    <div class="col-2 text-center">
        <img src="resources/images/branding/logo.png" width="50px">
    </div>
    <div class="col-4">
        <h1 class=" fw-bolder text-start">HowsApp</h1>
    </div>
    <div class="col-6 text-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
        <div class="position-relative">
            <img src="resources/images/icons/hamburgar.svg" width="50px">
            <?php
            if ($friend_request_num > 0) {
            ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger me-5">
                    <?php echo $friend_request_num ?>
                    <span class="visually-hidden">unread messages</span>
                </span>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start  pe-3" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="row text-center pt-3">
        <p class="fw-semibold">Hi! <?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?></p>
    </div>
    <div class="offcanvas-body">
        <ul class=" list-group list-group-flush">
            <li class="list-group-item list-group-item-action text-center"><a href="index.php" class="text-decoration-none text-dark fw-bold">Chat</a></li>
            <li class="list-group-item list-group-item-action text-center"><a href="profile.php" class="text-decoration-none  text-dark fw-bold">Profile</a></li>
            <li class="list-group-item list-group-item-action text-center position-relative"><a href="friends.php" class="text-decoration-none text-dark fw-bold">Friends
                    <?php
                    if ($friend_request_num > 0) {
                    ?>
                        <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger me-5">
                            <?php echo $friend_request_num ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    <?php
                    }
                    ?>
                </a></li>
            <li class="list-group-item list-group-item-action text-center"><a href="#" class="text-decoration-none text-dark fw-bold">Settings</a></li>
        </ul>

        <p class="text-center fw-bold mt-5" onclick="logout();"><i class="bi bi-box-arrow-right fw-bold fs-5"></i> Logout</p>

    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">