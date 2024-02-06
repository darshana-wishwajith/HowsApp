<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.css">
    <link rel="shortcut icon" href="resources/images/branding/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 vh-100 d-flex align-items-center">
                <div class="form-control gap-3 mt-3 mb-3 py-5">
                    <div class="col-10 offset-1 mb-5">
                        <h1>Create an account</h1>
                    </div>
                    <div class="col-10 offset-1">
                        <div class="row">
                            <div class="col-6">
                                <label for="fname" class="form-label">First Name : </label>
                                <input type="text" class="form-control" id="fname">
                            </div>
                            <div class="col-6">
                                <label for="lname" class="form-label">Last Name : </label>
                                <input type="text" class="form-control" id="lname">
                            </div>
                        </div>
                    </div>

                    <div class="col-10 offset-1">
                        <label for="genderSelector" class="form-label">Gender : </label>
                        <select id="genderSelector" class=" form-select">
                            <?php
                            include "includes/config.php";
                            $gender_rs = Database::search("SELECT * FROM `gender`");
                            $gender_num = $gender_rs->num_rows;

                            for ($i = 0; $i < $gender_num; $i++) {
                                $gender_data = $gender_rs->fetch_assoc();

                            ?>
                                <option value="<?php echo $gender_data['gender_id'] ?>"><?php echo $gender_data['gender_name'] ?></option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="col-10 offset-1">
                        <label for="RegistrationMail" class="form-label">Email : </label>
                        <input type="email" class="form-control" id="RegistrationMail">
                    </div>
                    <div class="col-10 offset-1">
                        <label for="vcode" class="form-label">Verification Code : </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="vcode" maxlength="6" aria-label="vcodeSender" aria-describedby="vcodeSender">
                            <button class="btn btn-primary" type="button" id="vcodeSender" onclick="sendVerification(document.getElementById('RegistrationMail'));"><span id="vcodeSenderSpan"></span> Send</button>
                        </div>
                    </div>

                    <div class="col-10 offset-1">
                        <label for="RegistrationPass" class="form-label">Password : </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="RegistrationPass" aria-label="passwordViewer" aria-describedby="passwordViewer">
                            <button class="btn btn-primary" type="button" id="passwordViewer" onclick="passwordViewer('RegistrationPass');"><i class="bi bi-eye-fill" id="passwordIcon"></i>
                        </div>

                    </div>

                    <div class="col-10 offset-1 mt-5">
                        <div class="row g-3">
                            <div class="col-6 d-grid">
                                <button class="btn btn-warning" onclick="window.location='login.php'">Already have an account ?</button>
                            </div>
                            <div class="col-6 d-grid">
                                <button class="btn btn-primary" onclick="register();">Register</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-5">
                        <small>&copy; 2024 Darahana Wishwajith. All rights reserved.</small>
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