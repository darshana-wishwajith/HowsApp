<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Login</title>
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
                        <h1>Welcome Back!</h1>
                    </div>
                    <div class="col-10 offset-1">
                        <label for="loginMail" class="form-label">Email : </label>
                        <input type="email" class="form-control" id="loginMail">
                    </div>
                    <div class="col-10 offset-1">
                        <label for="loginPass" class="form-label">Password : </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="loginPass" aria-label="passwordViewer" aria-describedby="passwordViewer">
                            <button class="btn btn-primary" type="button" id="passwordViewer" onclick="passwordViewer('loginPass');"><i class="bi bi-eye-fill" id="passwordIcon"></i>
                        </div>

                    </div>

                    <div class="col-10 offset-1 mt-5">
                        <div class="row g-3">
                            <div class="col-6 d-grid">
                                <button class="btn btn-warning" onclick="window.location='register.php'">Create an account</button>
                            </div>
                            <div class="col-6 d-grid">
                                <button class="btn btn-primary" onclick="login();">Login</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-10 offset-1 mt-3 text-end">
                        <a href="#" onclick="fogotPassword();">Forgot Password</a>
                    </div>

                    <div class="modal" tabindex="-1" id="fpmodal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Forgot Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="np" class="form-label">New Password : </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="np" aria-label="passwordViewer" aria-describedby="passwordViewer">
                                                <button class="btn btn-primary" type="button" id="passwordViewer" onclick="passwordViewer('np');"><img src="resources/images/icons/eye.svg" id="passwordIcon"></button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="rtp" class="form-label">Re-type Password : </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="rtp" aria-label="passwordViewer" aria-describedby="passwordViewer">
                                                <button class="btn btn-primary" type="button" id="passwordViewer" onclick="passwordViewer('rtp');"><img src="resources/images/icons/eye.svg" id="passwordIcon"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="vcode" class="form-label">Verification Code : </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="vcode" maxlength="6" aria-label="vcodeSender" aria-describedby="vcodeSender">
                                            <button class="btn btn-primary" type="button" id="vcodeSender" onclick="sendVerification(document.getElementById('loginMail'));"><span id="vcodeSenderSpan"></span> Send</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="changePassword();">Change Password</button>
                                </div>
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