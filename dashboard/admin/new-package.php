<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$admin_id = $_SESSION['admin_id'];

require_once './server/Admin.php';
$result = "";
$message = "";

$server = new Admin();
$result = $server->adminData();

if (isset($_POST['create'])) {
    $message = $server->create_package($_POST);
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
                font-weight: bolder !important;
                text-transform: uppercase;
            }

            form input {
                border: 1px solid !important;
                c
            }

        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
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
                        <div class="col-sm-10">
                            <h4 class="page-title"><u>CREATE PACKAGE</u>&nbsp;<i class="fa fa-plus-circle"></i>&emsp;
                                <span style="color:<?php
                                if ($message == 'Package exists.') {
                                    echo 'red';
                                } else {
                                    echo 'green';
                                }
                                ?>">
                                    <?php echo $message; ?></span></h4>
                        </div>
                        <div class="col-sm-2">
                            <a href="packages.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-cubes"></i> All Packages</a>
                        </div>
                    </div>
                    <form method="POST" action="" autocomplete="off">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Package Name<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="package_name" required>
                                            <option disabled>Selected</option>
                                            <option value="Bronze">Bronze</option>
                                            <option value="Silver">Silver</option>
                                            <option value="Gold">Gold</option>
                                            <option value="Platinum">Platinum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Publication Status<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="publication_status" required>
                                            <option disabled></option>
                                            <option value="1">Published</option>
                                            <option value="0">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Price in Taka<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="price_taka"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Price in USD<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="price_usd"  required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Message Limit<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="message_limit" required>
                                            <option value="500000">No Limit</option>
                                            <?php
                                            for ($i = 0; $i <= 10000; $i++) {
                                                ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Profile View Limit<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="view_limit" required>
                                            <option value="500000">No Limit</option>
                                            <?php
                                            for ($i = 0; $i <= 10000; $i++) {
                                                ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Request Limit<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="request_limit" required>
                                           <option value="500000">No Limit</option>
                                            <?php
                                            for ($i = 0; $i <= 10000; $i++) {
                                                ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 01</label>
                                        <input type="text" class="form-control floating" name="offer_1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 02</label>
                                        <input type="text" class="form-control floating" name="offer_2" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 03</label>
                                        <input type="text" class="form-control floating" name="offer_3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 04</label>
                                        <input type="text" class="form-control floating" name="offer_4">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 05</label>
                                        <input type="text" class="form-control floating" name="offer_5" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 06</label>
                                        <input type="text" class="form-control floating" name="offer_6">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 07</label>
                                        <input type="text" class="form-control floating" name="offer_7"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 08</label>
                                        <input type="text" class="form-control floating" name="offer_8"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 09</label>
                                        <input type="text" class="form-control floating" name="offer_9"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Offer 10</label>
                                        <input type="text" class="form-control floating" name="offer_10">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" type="submit" name="create">Create</button>
                        </div>

                    </form>
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/app.js"></script>

    </body>
</html>