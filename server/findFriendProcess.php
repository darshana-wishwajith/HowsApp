<?php
include "../includes/config.php";
session_start();

if (!isset($_POST["femail"])) {
    echo ("Something went wrong");
} else if (empty($_POST["femail"])) {
    echo ("Please enter an email of your friend");
} else if (!filter_var($_POST["femail"], FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid email");
} else {

    $femail = $_POST["femail"];

    $friend_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON user.gender_gender_id = gender.gender_id WHERE  `email` = '" . $femail . "'");

    $friend_num = $friend_rs->num_rows;

    $friend_add_rs = Database::search("SELECT * FROM `additional_data` WHERE `user_email` = '" . $femail . "'");

    $friend_add_num = $friend_add_rs->num_rows;
    
    $friends_count_rs = Database::search("SELECT * FROM `friend` WHERE `from` = '".$femail."' OR `to` = '".$femail."'");

    $friends_count_num = $friends_count_rs->num_rows;

    function getAge($dob){
        $birth_year = date_parse($dob)['year'];
        $curent_year = date('Y');
        $age = $curent_year - $birth_year;
        return $age;
    }
    

    if ($friend_num == 1) {

        $friend_data = $friend_rs->fetch_assoc();

        $fprofile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $femail . "'");

        $fprofile_img_num = $fprofile_img_rs->num_rows;

        if ($fprofile_img_num == 1) {

            $fprofile_img_data = $fprofile_img_rs->fetch_assoc();

?>

            <div class="col-10 offset-1">
                <div class="border rounded-3 mt-3 p-4">
                    <div class="col-12 text-center mb-3">
                        <img src="<?php echo $fprofile_img_data['path'] ?>" width="100px" class=" rounded-circle">
                    </div>
                    <div class="col-12 text-center">
                        <span class="fw-bold"><?php echo $friend_data["fname"] . " " . $friend_data["lname"]; ?></span><br>
                        <span class="fw-semibold"><?php echo $friend_data["email"] ?></span>
                        <?php
                            if ($friend_add_num > 0) {
                                $friend_add_data = $friend_add_rs->fetch_assoc();

                                if($friend_add_data["mobile_number"] != null){
                                    ?>
                                        <P class="text-center"><?php echo $friend_add_data["mobile_number"]?></P>
                                    <?php
                                }
                                else{
                                    ?>
                                        <P class="text-center">07********</P>
                                    <?php
                                }
                                ?>
                                <hr>
                                <span class="badge text-bg-dark  me-2">
                                    <?php 
                                    if($friend_add_data["dob"] != "0000-00-00"){
                                        echo getAge($friend_add_data["dob"])." "."years old";
                                    }
                                    else{
                                        echo "unknown age";
                                    }
                                    
                                    ?>
                                    </span>
                                    <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark"><span class="fw-bold">
                                    <?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?>
                                </span> Friends</span>
                                <hr>
                                <span class="fw-semibold">
                                    <?php 
                                    if($friend_add_data["city"] != null){
                                        echo $friend_add_data["city"];
                                    }   
                                    else{
                                        echo "unknown city";
                                    }
                                    ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <P class="text-center">07********</P>
                                <hr>
                                <span class="badge text-bg-dark  me-2">unknown age</span>
                                <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark "><span class="fw-bold"><?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?></span> Friends</span>
                                <hr>
                                <span class="fw-semibold">unknown city</span>
                            <?php
                            }
                            ?>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <?php
                        $fs_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $femail . "' OR `to` = '" . $femail . "') AND (`from` = '" . $_SESSION['user']['email'] . "' OR `to` = '" . $_SESSION['user']['email'] . "')");

                        $fs_num = $fs_rs->num_rows;

                        if ($femail == $_SESSION["user"]["email"]) {
                        ?>
                            <button class="btn btn-primary" disabled>me</button>
                            <?php
                        } else {
                            if ($fs_num == 0) {
                            ?>
                                <button class="btn btn-primary" onclick="addFriend('<?php echo $femail ?>');">add</button>
                                <?php
                            } else {
                                $fs_data = $fs_rs->fetch_assoc();

                                $friend_status_code = $fs_data["friend_status_fs_id"];

                                if ($friend_status_code == 1) {
                                ?>
                                    <button class="btn btn-warning" disabled>pending</button>
                                <?php
                                } else if ($friend_status_code == 2) {
                                ?>
                                    <button class="btn btn-success" disabled>friends</button>
                                <?php
                                } else if ($friend_status_code == 3) {
                                ?>
                                    <button class="btn btn-danger" disabled>rejected</button>
                        <?php
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

            <?php

        } else {
            if ($friend_data["gender_gender_id"] == 1) {
                //male

            ?>

                <div class="col-10 offset-1">
                    <div class="border rounded-3 mt-3 p-4">
                        <div class="col-12 text-center  mb-3">
                            <img src="resources/images/profile/sample_male.jpg" width="100px" class=" rounded-circle">
                        </div>
                        <div class="col-12 text-center">
                            <span class="fw-bold"><?php echo $friend_data["fname"] . " " . $friend_data["lname"]; ?></span><br>
                            <span class="fw-semibold"><?php echo $friend_data["email"] ?></span>
                            <?php
                            if ($friend_add_num > 0) {
                                $friend_add_data = $friend_add_rs->fetch_assoc();

                                if($friend_add_data["mobile_number"] != null){
                                    ?>
                                        <P class="text-center"><?php echo $friend_add_data["mobile_number"]?></P>
                                    <?php
                                }
                                else{
                                    ?>
                                        <P class="text-center">07********</P>
                                    <?php
                                }
                                ?>
                                <hr>
                                <span class="badge text-bg-dark  me-2">
                                    <?php 
                                    if($friend_add_data["dob"] != null){
                                        echo getAge($friend_add_data["dob"])." "."years old";
                                    }
                                    else{
                                        echo "unknown age";
                                    }
                                    
                                    ?>
                                    </span>
                                    <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark"><span class="fw-bold">
                                    <?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?>
                                </span> Friends</span>
                                <hr>
                                <span class="fw-semibold">
                                    <?php 
                                    if($friend_add_data["city"] != null){
                                        echo $friend_add_data["city"];
                                    }   
                                    else{
                                        echo "unknown city";
                                    }
                                    ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <P class="text-center">07********</P>
                                <hr>
                                <span class="badge text-bg-dark  me-2">unknown age</span>
                                <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark "><span class="fw-bold"><?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?></span> Friends</span>
                                <hr>
                                <span class="fw-semibold">unknown city</span>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <?php
                            $fs_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $femail . "' OR `to` = '" . $femail . "') AND (`from` = '" . $_SESSION['user']['email'] . "' OR `to` = '" . $_SESSION['user']['email'] . "')");

                            $fs_num = $fs_rs->num_rows;

                            if ($femail == $_SESSION["user"]["email"]) {
                            ?>
                                <button class="btn btn-primary" disabled>me</button>
                                <?php
                            } else {
                                if ($fs_num == 0) {
                                ?>
                                    <button class="btn btn-primary" onclick="addFriend('<?php echo $femail ?>');">add</button>
                                    <?php
                                } else {
                                    $fs_data = $fs_rs->fetch_assoc();

                                    $friend_status_code = $fs_data["friend_status_fs_id"];

                                    if ($friend_status_code == 1) {
                                    ?>
                                        <button class="btn btn-warning" disabled>pending</button>
                                    <?php
                                    } else if ($friend_status_code == 2) {
                                    ?>
                                        <button class="btn btn-success" disabled>friends</button>
                                    <?php
                                    } else if ($friend_status_code == 3) {
                                    ?>
                                        <button class="btn btn-danger" disabled>rejected</button>
                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>

            <?php

            } else {
                //female

            ?>

                <div class="col-10 offset-1">
                    <div class="border rounded-3 mt-3 p-4">
                        <div class="col-12 text-center  mb-3">
                            <img src="resources/images/profile/sample_female.jpg" width="100px" class=" rounded-circle">
                        </div>
                        <div class="col-12 text-center">
                            <span class="fw-bold"><?php echo $friend_data["fname"] . " " . $friend_data["lname"]; ?></span><br>
                            <span class="fw-semibold"><?php echo $friend_data["email"] ?></span>
                            <?php
                            if ($friend_add_num > 0) {
                                $friend_add_data = $friend_add_rs->fetch_assoc();

                                if($friend_add_data["mobile_number"] != null){
                                    ?>
                                        <P class="text-center"><?php echo $friend_add_data["mobile_number"]?></P>
                                    <?php
                                }
                                else{
                                    ?>
                                        <P class="text-center">07********</P>
                                    <?php
                                }
                                ?>
                                <hr>
                                <span class="badge text-bg-dark  me-2">
                                    <?php 
                                    if($friend_add_data["dob"] != null){
                                        echo getAge($friend_add_data["dob"])." "."years old";
                                    }
                                    else{
                                        echo "unknown age";
                                    }
                                    
                                    ?>
                                    </span>
                                    <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark"><span class="fw-bold">
                                    <?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?>
                                </span> Friends</span>
                                <hr>
                                <span class="fw-semibold">
                                    <?php 
                                    if($friend_add_data["city"] != null){
                                        echo $friend_add_data["city"];
                                    }   
                                    else{
                                        echo "unknown city";
                                    }
                                    ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <P class="text-center">07********</P>
                                <hr>
                                <span class="badge text-bg-dark  me-2">unknown age</span>
                                <?php 
                                        if($friend_data["gender_name"] == "male"){
                                            ?>
                                                <span class="badge text-bg-info bg-opacity-50 me-2">boy</span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <span class="badge text-bg-danger bg-opacity-50 me-2">girl</span>
                                            <?php
                                        }
                                    ?>
                                <span class="bg-opacity-50 badge text-bg-dark "><span class="fw-bold"><?php
                                        if($friends_count_num > 0){
                                            echo $friends_count_num ;
                                        }
                                        else{
                                            echo "0";
                                        }
                                    ?></span> Friends</span>
                                <hr>
                                <span class="fw-semibold">unknown city</span>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <?php
                            $fs_rs = Database::search("SELECT * FROM `friend` WHERE (`from` = '" . $femail . "' OR `to` = '" . $femail . "') AND (`from` = '" . $_SESSION['user']['email'] . "' OR `to` = '" . $_SESSION['user']['email'] . "')");

                            $fs_num = $fs_rs->num_rows;

                            if ($femail == $_SESSION["user"]["email"]) {
                            ?>
                                <button class="btn btn-primary" disabled>me</button>
                                <?php
                            } else {
                                if ($fs_num == 0) {
                                ?>
                                    <button class="btn btn-primary" onclick="addFriend('<?php echo $femail ?>');">add</button>
                                    <?php
                                } else {
                                    $fs_data = $fs_rs->fetch_assoc();

                                    $friend_status_code = $fs_data["friend_status_fs_id"];

                                    if ($friend_status_code == 1) {
                                    ?>
                                        <button class="btn btn-warning" disabled>pending</button>
                                    <?php
                                    } else if ($friend_status_code == 2) {
                                    ?>
                                        <button class="btn btn-success" disabled>friends</button>
                                    <?php
                                    } else if ($friend_status_code == 3) {
                                    ?>
                                        <button class="btn btn-danger" disabled>rejected</button>
                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>

<?php


            }
        }
    } else {
        echo ("faild");
    }
}
?>