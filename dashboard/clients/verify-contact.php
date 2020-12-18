<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";
$error = "";



$server = new Client();
$result = $server->viewData();

if (isset($_POST['submit'])) {
    $error = $server->contact_varification();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            label, h3, .page-title {
                font-family: 'Rajdhani', sans-serif !important;
                font-weight: bolder !important;
                text-transform: uppercase
            }

            form input {
                border: 1px solid !important;
            }

        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
                $payment_status = $row['payment_status'];
                $contact_status = $row['contact_status'];
                $contact_number = $row['phone'];
                ?>

                <?php
                if ($row['status'] == 0) {
                    echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
                }
                ?>

                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>
                <div class="sidebar" id="sidebar">
                    <?php include './parts/side-nav.php'; ?>
                </div>
            <?php } ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="page-title"><u>Contact Verification</u>&nbsp;
                                <i class="fa fa-check-circle" style="color:<?php
                                if ($contact_status == 0) {
                                    echo'red';
                                } else {
                                    echo 'green';
                                }
                                ?>"></i>
                            </h4>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                    <?php
                    if ($contact_status == 0) {
                        ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <form method="POST" action="">
                                            <center>
                                                <div class="form-group">
                                                    <label class="text-danger">We've sent a 6 digit verification code to &nbsp;<span style="color:black"><?php echo $contact_number ?></span>.&nbsp;Please provide the code here.</label>
                                                    <input type="password" class="form-control" placeholder="varification code" value="" name="verification_code" autocomplete="new-password" required>
                                                    <br>
                                                    <input type="submit" class="btn btn-primary btn-lg" name="submit">
                                                    <h4 style="font-family: 'Titillium Web', sans-serif;color:red"><?php echo $error; ?></h4>
                                                </div>
                                            </center>
                                        </form>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>   
                            </div>
                            <div class="col-sm-2"></div>
                        </div>   

                    <?php } else { ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <center>
                                    <h1 style="text-align: center;color:green; font-family: 'Titillium Web', sans-serif; ">
                                        <b>CONTACT IS VERIFIED!</b>
                                    </h1>
                                    <br>
                                    <i class="fa fa-check-circle" style="font-size:100px;color:green"></i>
                                </center>

                            </div>
                            <div class="col-sm-2"></div>
                        </div>

                    <?php } ?>
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
    </body>
</html>