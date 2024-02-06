<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HowsAPP | Public Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/bootstrap/bootstrap.css">
    <link rel="shortcut icon" href="resources/images/branding/logo.png" type="image/x-icon">
</head>
<?php $email = $_GET["e"]; ?>

<body onload="getPublicProdile('<?php echo $email ?>');">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-6 offset-md-3">
                <?php include "header.php"; ?>

            
                    <div id="publicProfile" class="mt-5">

                    </div>
         


            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="includes/bootstrap/bootstrap.js"></script>
    <script src="includes/bootstrap/bootstrap.bundle.js"></script>
</body>

</html>