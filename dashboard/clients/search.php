<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";
$updateError = "";

$server = new Client();
$result = $server->viewData();
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
                $profile_status = $row['profile_status'];
                $payment_status = $row['payment_status'];
                $gender = $row['gender'];
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
                            <h4 class="page-title"><u>SEARCH</u>&nbsp;<i class="fa fa-search"></i></h4>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                    <form method="GET" action="search-results.php">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Country<span class="text-danger">*</span></label>
                                        <select class = "form-control floating select" name = "country" required>
                                            <?php include '../../dashboard/countries.php';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Looking For<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="gender" required>
                                            <option disabled></option>
                                            <option <?php
                                            if ($gender == 'Female') {
                                                echo 'selected';
                                            }
                                            ?> value="Male">Man</option>
                                            <option <?php
                                            if ($gender == 'Male') {
                                                echo 'selected';
                                            }
                                            ?> value="Female">Woman</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Religion<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="religion" required>
                                            <option disabled>Select</option>
                                            <option>Islam</option>
                                            <option>Christianity</option>
                                            <option>Judaism</option>
                                            <option>Hinduism</option>
                                            <option>Buddhism</option>
                                            <option>Atheist</option>
                                            <option>Any</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Marital Status<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="marital_status" required>
                                            <option disabled>Select</option>
                                            <option>Unmarried</option>
                                            <option>Married</option>
                                            <option>Divorced</option>
                                            <option>Any</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Age From<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="age_from" required>
                                            <option disabled>Select</option>
                                            <?php for ($i = 18; $i <= 100; $i++) { ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Age To<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="age_to" required>
                                            <option disabled>Select</option>
                                            <?php for ($i = 19; $i <= 100; $i++) { ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php if ($profile_status == 1) { ?>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" type="submit" name="search">Search</button>
                            </div>
                        <?php } else { ?>
                            <div class="m-t-20 text-center">
                                <a href="#modal1" class="btn btn-primary">Search</a>
                            </div>
                            <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                                <center>
                                    <h3 class="modal-title text-danger" s>Sorry! Your profile is incomplete.Do you want to update your profile?</h3>
                                    <br>
                                    <a class="btn btn-success" href="update-profile.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                                </center>
                            </div>
                        <?php } ?>
                    </form>
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
    </body>
</html>