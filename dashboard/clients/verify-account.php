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

if(isset($_POST['try_again'])){
    $server->try_again();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            .content {
                 font-family: 'Titillium Web', sans-serif; 
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
                $account_status = $row['account_status'];
                $verification_request = $row['verification_request'];
                $verification_failed = $row['verification_failed'];
                $failed_cause = $row['failed_cause'];
                $payment_status = $row['payment_status'];
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
                            <h4 class="page-title"><u>Account Verification</u>&nbsp;
                                <i class="fa fa-check-circle" style="color:<?php
                                if ($account_status == 0 && $verification_request == 0 && $verification_failed == 1) {
                                    echo'red';
                                } elseif ($verification_request == 1) {
                                    echo 'blueviolet';
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
                    if ($account_status == 0 && $verification_request == 0 && $verification_failed == 0) {
                        ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <center>
                                            <h3 class="modal-title">How do you want to verify your account?</h3>
                                            <br>
                                            <a href="nid-verification.php" class="btn btn-success" style="width: 160px">NID Verification</a>
                                            &emsp;||&emsp;
                                            <a href="passport-verification.php" class="btn btn-primary">Passport Verification</a>
                                        </center>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>   
                            </div>
                            <div class="col-sm-2"></div>
                        </div>   

                    <?php } elseif ($verification_request == 1) { ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <center>
                                    <h1 style="text-align: center;color:blueviolet; ">
                                        <b>You have a pending request.</b>
                                    </h1>
                                    <br>
                                    <i class="fa fa-clock-o" style="font-size:100px;color:blueviolet"></i>
                                </center>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    <?php } elseif ($account_status == 1) { ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <center>
                                    <h1 style="text-align: center;color:green;">
                                        <b>ACCOUNT VERIFIED!</b>
                                    </h1>
                                    <br>
                                    <i class="fa fa-check-circle" style="font-size:100px;color:green"></i>
                                </center>

                            </div>
                            <div class="col-sm-2"></div>
                        </div>

                    <?php } else { ?>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 card-box" style="min-height:200px">
                                <center>
                                    <h1 style="text-align: center;color:red;">
                                        <b>ACCOUNT VERIFICATION FAILED!</b>
                                    </h1>
                                    <br>
                                    <i class="fa fa-times-circle" style="font-size:100px;color:red"></i>
                                    <h4><?php echo $failed_cause; ?></h4>
                                    <form method="POST">
                                        <input type="submit" name="try_again" class="btn btn-primary" value="Try Again"/>
                                    </form>
                                </center>

                            </div>
                            <div class="col-sm-2"></div>
                        </div>

                    <?php } ?>
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
    </body>
</html>