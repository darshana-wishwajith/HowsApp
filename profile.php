<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.css">
    <link rel="shortcut icon" href="resources/images/branding/logo.png" type="image/x-icon">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <?php include "header.php";
                include_once "includes/config.php";

                if(!isset($_SESSION["user"])){
                    header("Location:login.php");
                }

                $current_user = $_SESSION["user"]["email"];



             
                $user_rs = Database::search("SELECT * FROM `user` LEFT JOIN `profile_img` ON user.email =  profile_img.user_email LEFT JOIN `additional_data` ON user.email = additional_data.user_email WHERE user.email = '".$current_user."'");
                     
                $user_data = $user_rs->fetch_assoc();

                ?>
                <div class="row my-3">
                    <div class="col-10 offset-1">
                        <div class="border rounded-3">
                            <div class="row pt-3">
                                <div class="text-center">
                                    <h1 class="fw-bold">P R O F I L E</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center py-3">
                                    <?php
                                        if($user_data["path"] != null){
                                            ?>
                                                    <img src="<?php echo $user_data['path'] ?>" class="rounded-circle" style="width:150px;" id="profile_img">
                                                <?php
                                        }
                                        else{
                                            if($user_data["gender_gender_id"] == 1){
                                                ?>
                                                    <img src="resources/images/profile/sample_male.jpg" class="rounded-circle" style="width:150px;" id="profile_img">
                                                <?php
                                            }
                                            else{

                                                ?>
                                                    <img src="resources/images/profile/sample_female.jpg" class="rounded-circle" style="width:150px;" id="profile_img">
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="col-12 text-center">
                                    <input type="file" id="ProfilePicUpload" class=" form-control visually-hidden" onchange="ProfilePicUpload();">
                                    <button class="btn btn-primary mb-3" onclick="openFileUploader();">Change Profile Pictute</button>
                                </div>
                            </div>

                            <div class="row px-3 pb-2 g-2">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profileFname" value="<?php echo $user_data['fname'] ?>" placeholder="First Name">
                                        <label for="profileFname">First Name</label>
                                    </div>
                                </div>
                                <div class="col-6 ">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profileLname" value="<?php echo $user_data['lname'] ?>" placeholder="Last Name">
                                        <label for="profileLname">Last Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="profileEmail" value="<?php echo $user_data['email'] ?>" placeholder="Email" disabled>
                                        <label for="profileEmail">Email</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="profilePass" value="<?php echo $user_data['password'] ?>" placeholder="Password">
                                            <button class="btn btn-primary" onclick="passwordViewer(document.getElementById('profilePass').id);"><i class="bi bi-eye-slash-fill" id="passwordIcon"></i></button>
                                        </div>
                                </div>
                            </div>

                            <div class="row px-3 pb-2 g-2">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <?php
                                            $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '".$user_data['gender_gender_id']."'");

                                            $gender_data = $gender_rs->fetch_assoc();
                                        ?>
                                        <input type="text" class="form-control" id="profileGender" value="<?php echo $gender_data['gender_name']?>" placeholder="Gender" disabled>
                                        <label for="profileGender">Gender</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="profileMobile" value="<?php echo $user_data['mobile_number'] ?>" placeholder="Mobile" maxlength="10">
                                        <label for="profileMobile">Mobile</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="profiledob" value="<?php echo $user_data['dob'] ?>" placeholder="Birthday" >
                                        <label for="profiledob">Birthday</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profileAdLine1" value="<?php echo $user_data['address_line1'] ?>" placeholder="Address Line 1">
                                        <label for="profileAdLine1">Address Line 1</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profileAdLine2" value="<?php echo $user_data['address_line2'] ?>" placeholder="Address Line 2">
                                        <label for="profileAdLine2">Address Line 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3 pb-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profilecity" value="<?php echo $user_data['city'] ?>" placeholder="City">
                                        <label for="profilecity">City</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 mt-3 text-center">
                            <div class="col-12">
                                    <button class="btn btn-primary mb-3" id="profileUpdateBtn" onclick="uploadProfile(document.getElementById('profileEmail').value);"><span id="profileUpdateSpinner"></span> Update Profile</button>
                                </div>
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