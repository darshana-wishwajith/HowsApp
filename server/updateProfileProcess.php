<?php
    session_start();
    include_once "../includes/config.php";

    $errors = 0;

    if(!isset($_SESSION["user"])){
        $errors+=1;
        echo("Something went wrong");
    }
    else{
        $current_user = $_SESSION["user"]["email"];

        if(!isset($_POST["email"])){
            $errors+=1;
            echo("Something went wrong");
        }
        else{
            if($current_user != $_POST["email"]){
                $errors+=1;
                echo("Something went wrong");
            }
            else{

                $have_pro_img = false;

                if(isset($_FILES["img"])){
                    $have_pro_img = true;
                }

                if(!isset($_POST["fname"]) || !isset($_POST["lname"]) || !isset($_POST["password"]) || !isset($_POST["mobile"]) || !isset($_POST["dob"]) || !isset($_POST["adl1"]) || !isset($_POST["adl2"]) || !isset($_POST["city"]) ){
                    $errors+=1;

                    echo("Something went wrong");
                }
                else{

                    if(empty($_POST["fname"])){
                        $errors+=1;
                        echo("First name can't empty");
                    }
                    else if(empty($_POST["lname"])){
                        $errors+=1;
                        echo("Last name can't empty");
                    }
                    else if(empty($_POST["password"])){
                        $errors+=1;
                        echo("Password can't empty");
                    }
                    else{

                        $fname = $_POST["fname"];
                        $lname = $_POST["lname"];
                        $password = $_POST["password"];
                        $mobile;
                        $dob;
                        $address1;
                        $address2;
                        $city;

                        if(!empty($_POST["mobile"])){
                            $regex = "/07[1,2,4,5,6,7,8]{1}[0-9]{7}/";
                            if(!preg_match($regex, $_POST["mobile"])){
                                $errors+=1;
                                echo("Invalid Mobile number");
                            }
                            else{
                                $mobile_rs = Database::search("SELECT * FROM `additional_data` WHERE `mobile_number` = '".$_POST["mobile"]."'");

                                $mobile_num = $mobile_rs->num_rows;

                                if($mobile_num != 0){
                                    $mobile_data = $mobile_rs->fetch_assoc();

                                    if($mobile_data['user_email'] == $current_user){
                                        $mobile = $_POST["mobile"];
                                    }
                                    else{
                                        $errors+=1;
                                        echo("Mobile number already exists. Please enter another mobile number.");
                                        $mobile = null;
                                    }
                                    
                                }
                                else{
                                    $mobile = $_POST["mobile"];
                                }
                            }

                        }
                        else{
                            $mobile = null;
                        }

                        if(!empty($_POST["dob"])){
                            $dob = $_POST["dob"];
                        }
                        else if($_POST["dob"] == 'yyyy-mm-dd'){
                            $dob = null;
                        }
                        else{
                            $dob = null;
                        }

                        if(!empty($_POST["adl1"])){
                            $address1 = $_POST["adl1"];
                        }
                        else{
                            $address1 = null;
                        }

                        if(!empty($_POST["adl2"])){
                            $address2 = $_POST["adl2"];
                        }
                        else{
                            $address2 = null;
                        }

                        if(!empty($_POST["city"])){
                            $city = $_POST["city"];
                        }
                        else{
                            $city = null;
                        }

                        Database::insert_update_delete("UPDATE `user` SET `fname`='".$fname."', `lname`='".$lname."', `password`='".$password."' WHERE `email`='".$current_user."'");

                        $addtional_rs = Database::search("SELECT * FROM `additional_data` WHERE `user_email` = '".$current_user."'");

                        $addtional_num = $addtional_rs->fetch_assoc();

                        if($addtional_num != 0){
                            Database::insert_update_delete("UPDATE `additional_data` SET `dob`='".$dob."', `mobile_number`='".$mobile."', `address_line1`='".$address1."', `address_line2`='".$address2."', `city`='".$city."' WHERE `user_email`='".$current_user."'");
                        }
                        else{
                            Database::insert_update_delete("INSERT INTO `additional_data` (`dob`, `mobile_number`, `address_line1`, `address_line2`, `city`, `user_email`) VALUES('".$dob."', '".$mobile."', '".$address1."', '".$address2."', '".$city."', '".$current_user."')");
                        }


                    }
                }

                if($have_pro_img){
                    $profile_img = $_FILES['img'];

                    $tmp_name = $profile_img["tmp_name"];
                    $file_type = $profile_img["type"];

                    $img_extention;

                    if($file_type == "image/jpg"){
                        $img_extention = "jpg";
                    }
                    else if($file_type == "image/jpeg"){
                        $img_extention = "jpeg";
                    }
                    else if($file_type == "image/png"){
                        $img_extention = "png";
                    }
                    else if($file_type == "image/svg"){
                        $img_extention = "svg";
                    }
                    else{
                        $errors+=1;
                        echo("Unsupported file format");
                    }
                    $upload_img_path = "..//resources//images//profile//";
                    $save_img_path = "resources//images//profile//";

                    $img_name = $current_user.".".$img_extention;

                    $upload_img = $upload_img_path.$img_name;
                    $save_img = $save_img_path.$img_name;

                    move_uploaded_file($tmp_name, $upload_img);
                    
                    $profile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '".$current_user."'");

                    $profile_img_num = $profile_img_rs->num_rows;

                    if($profile_img_num == 0){
                        Database::insert_update_delete("INSERT INTO `profile_img` (`path`,`user_email`) VALUES('".$save_img."', '".$current_user."')");
                    }
                    else{
                        Database::insert_update_delete("UPDATE `profile_img` SET `path` = '".$save_img."' WHERE `user_email` = '".$current_user."'");
                    }
                }

                if($errors == 0){
                    echo("success");
                }
            }
        }
    }
?>