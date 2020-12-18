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

$bronze = $server->package_bronze();
$silver = $server->package_silver();
$gold = $server->package_gold();
$platinum = $server->package_platinum();

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
            #price {
                text-align: center;
            }

            .plan {
                display: inline-block;
                font-family: 'Titillium Web', sans-serif;
            }

            .plan-inner {
                min-height: 485px;
                background: #fff;
                margin: 0 auto;
                min-width: 280px;
                max-width: 100%;
                position:relative;
            }

            .entry-title {
                background: #53CFE9;
                height: 140px;
                position: relative;
                text-align: center;
                color: #fff;
                margin-bottom: 30px;
            }

            .entry-title>h3 {
                background: #20BADA;
                font-size: 20px;
                padding: 5px 0;
                text-transform: uppercase;
                font-weight: 700;
                margin: 0;
            }

            .entry-title .price {
                position: absolute;
                bottom: -25px;
                background: #20BADA;
                height: 95px;
                width: 95px;
                margin: 0 auto;
                left: 0;
                right: 0;
                overflow: hidden;
                border-radius: 50px;
                border: 5px solid #fff;
                line-height: 80px;
                font-size: 28px;
                font-weight: 700;
            }

            .price span {
                position: absolute;
                font-size: 9px;
                bottom: -10px;
                left: 30px;
                font-weight: 400;
            }

            .entry-content {
                color: #323232;
            }

            .entry-content ul {
                margin: 0;
                padding: 0;
                list-style: none;
                text-align: center;
            }

            .entry-content li {
                border-bottom: 1px solid #E5E5E5;
                padding: 10px 0;
            }

            .entry-content li:last-child {
                border: none;
            }

            .button {
                padding: 3em 0;
                text-align: center;
            }

            .button a {
                background: #323232;
                padding: 10px 30px;
                color: #fff;
                text-transform: uppercase;
                font-weight: 700;
                text-decoration: none
            }
            .hot {
                position: absolute;
                top: -7px;
                background: #F80;
                color: #fff;
                text-transform: uppercase;
                z-index: 2;
                padding: 2px 5px;
                font-size: 9px;
                border-radius: 2px;
                right: 10px;
                font-weight: 700;
            }
            .basic .entry-title {
                background: #75DDD9;
            }

            .basic .entry-title > h3 {
                background: #44CBC6;
            }

            .basic .price {
                background: #44CBC6;
            }

            .standard .entry-title {
                background: #4484c1;
            }

            .standard .entry-title > h3 {
                background: #3772aa;
            }

            .standard .price {
                background: #3772aa;
            }

            .ultimite .entry-title > h3 {
                background: #DD4B5E;
            }

            .ultimite .entry-title {
                background: #F75C70;
            }

            .ultimite .price {
                background: #DD4B5E;
            }

            label, h3, .page-title {
                font-weight: bolder !important;

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
                            <h4 class="page-title"><u>PACKAGES</u>&nbsp;<i class="fa fa-cubes"></i>&emsp;<span style="color:green"><?php echo $message; ?></span></h4>
                        </div>
                        <div class="col-sm-2">
                            <a href="new-package.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> New Package</a>
                        </div>
                    </div>
                    <div id="price" class="row">
                        <!--price tab-->
                        <div class="col-sm-3 plan"  >
                            <?php while ($row = $bronze->fetch_assoc()) { ?>
                                <div class="plan-inner" >
                                    <div class="entry-title" style="background-color: #cd7f32">
                                        <h2 style="background-color: #cd7f32;"><u><?php echo $row['package_name'] ?></u></h2>
                                        <div class="">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                            <h4>[<?php if($row['publication_status'] == 0){echo 'Unpublished';}else{echo 'Published';}  ?>]</h4>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php if($row['offer_1'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                 <?php if($row['offer_2'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                 <?php if($row['offer_3'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                 <?php if($row['offer_4'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                 <?php if($row['offer_5'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                 <?php if($row['offer_6'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                 <?php if($row['offer_7'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                 <?php if($row['offer_8'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                 <?php if($row['offer_9'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                 <?php if($row['offer_10'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <div class="button">
                                        <a href="update-package.php?package_name=<?php echo $row['package_name'] ?>">Update</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan basic">
                            <?php while ($row = $silver->fetch_assoc()) { ?>
                                <div class="plan-inner" >
                                    <div class="entry-title" style="background-color: #D3D3D3;color:black">
                                        <h2 style="background-color: #D3D3D3;"><u><?php echo $row['package_name'] ?></u></h2>
                                        <div style="">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                            <h4>[<?php if($row['publication_status'] == 0){echo 'Unpublished';}else{echo 'Published';}  ?>]</h4>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php if($row['offer_1'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                 <?php if($row['offer_2'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                 <?php if($row['offer_3'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                 <?php if($row['offer_4'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                 <?php if($row['offer_5'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                 <?php if($row['offer_6'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                 <?php if($row['offer_7'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                 <?php if($row['offer_8'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                 <?php if($row['offer_9'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                 <?php if($row['offer_10'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <div class="button">
                                        <a href="update-package.php?package_name=<?php echo $row['package_name'] ?>">Update</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan standard">
                            <?php while ($row = $gold->fetch_assoc()) { ?>
                                <div class="plan-inner" >
                                    <div class="hot">hot</div>
                                    <div class="entry-title" style="background-color: #FFD700;color:green">
                                        <h2 style="background-color: #FFD700;"><u><?php echo $row['package_name'] ?></u></h2>
                                        <div >
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                            <h4>[<?php if($row['publication_status'] == 0){echo 'Unpublished';}else{echo 'Published';}  ?>]</h4>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php if($row['offer_1'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                 <?php if($row['offer_2'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                 <?php if($row['offer_3'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                 <?php if($row['offer_4'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                 <?php if($row['offer_5'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                 <?php if($row['offer_6'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                 <?php if($row['offer_7'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                 <?php if($row['offer_8'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                 <?php if($row['offer_9'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                 <?php if($row['offer_10'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <div class="button">
                                        <a href="update-package.php?package_name=<?php echo $row['package_name'] ?>">Update</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan ultimite">
                            <?php while ($row = $platinum->fetch_assoc()) { ?>
                                <div class="plan-inner" style="">
                                    <div class="entry-title">
                                        <h3><?php echo $row['package_name'] ?></h3>
                                        <div style="color:wheat">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                            <h4>[<?php if($row['publication_status'] == 0){echo 'Unpublished';}else{echo 'Published';}  ?>]</h4>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php if($row['offer_1'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                 <?php if($row['offer_2'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                 <?php if($row['offer_3'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                 <?php if($row['offer_4'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                 <?php if($row['offer_5'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                 <?php if($row['offer_6'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                 <?php if($row['offer_7'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                 <?php if($row['offer_8'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                 <?php if($row['offer_9'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                 <?php if($row['offer_10'] == ""){echo '<i class="fa fa-times"></i>';} ?>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <div class="button">
                                        <a href="update-package.php?package_name=<?php echo $row['package_name'] ?>">Update</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- end of price tab-->
                    </div>
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