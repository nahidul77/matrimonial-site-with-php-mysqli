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

$bronze = $server->package_bronze();
$silver = $server->package_silver();
$gold = $server->package_gold();
$platinum = $server->package_platinum();

if (isset($_POST['submit'])) {
    $error = $server->purchase_package($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            @import url(https://fonts.googleapis.com/css?family=Lato:400,700);


            #price {
                text-align: center;
            }

            .plan {
                display: inline-block;

            }

            .plan-inner {
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
            .modal-title{
                color:red;
            }

        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
                $account_status = $row['account_status'];
                $contact_status = $row['contact_status'];
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
                            <h4 class="page-title"><u>MAKE A CHOICE</u>&nbsp;<i class="fa fa-check-circle-o"></i></h4>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $error; ?>
                        </div>
                    </div>
                    <div id="price" class="row">
                        <!--price tab-->
                        <div class="col-sm-3 plan">
                            <div class="plan-inner">
                                <?php while ($row = $bronze->fetch_assoc()) { ?>
                                    <div class="entry-title" >
                                        <h3><?php echo $row['package_name'] ?></h3>
                                        <div class="text-danger" style="color:white">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php
                                                if ($row['offer_1'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                <?php
                                                if ($row['offer_2'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                <?php
                                                if ($row['offer_3'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                <?php
                                                if ($row['offer_4'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                <?php
                                                if ($row['offer_5'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                <?php
                                                if ($row['offer_6'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                <?php
                                                if ($row['offer_7'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                <?php
                                                if ($row['offer_8'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                <?php
                                                if ($row['offer_9'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                <?php
                                                if ($row['offer_10'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>

                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="button">
                                    <?php if ($account_status == 0 || $contact_status == 0) { ?>
                                        <a href="#modal1">Order Now</a>
                                    <?php } else { ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="package_name" value="Bronze"/>
                                            <input type="submit" value="Purchase Now" name="submit" class="btn btn-dark" />
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan basic">
                            <div class="plan-inner">
                                <?php while ($row = $silver->fetch_assoc()) { ?>
                                    <div class="entry-title">
                                        <h3><?php echo $row['package_name'] ?></h3>
                                        <div class="" style="color:white">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php
                                                if ($row['offer_1'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                <?php
                                                if ($row['offer_2'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                <?php
                                                if ($row['offer_3'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                <?php
                                                if ($row['offer_4'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                <?php
                                                if ($row['offer_5'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                <?php
                                                if ($row['offer_6'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                <?php
                                                if ($row['offer_7'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                <?php
                                                if ($row['offer_8'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                <?php
                                                if ($row['offer_9'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                <?php
                                                if ($row['offer_10'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>

                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="button">
                                    <?php if ($account_status == 0 || $contact_status == 0) { ?>
                                        <a href="#modal1">Order Now</a>
                                    <?php } else { ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="package_name" value="Silver"/>
                                            <input type="submit" value="Purchase Now" name="submit" class="btn btn-dark" />
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan standard">
                            <div class="plan-inner">
                                <?php while ($row = $gold->fetch_assoc()) { ?>
                                    <div class="hot">hot</div>
                                    <div class="entry-title">
                                        <h3><?php echo $row['package_name'] ?></h3>
                                        <div class="" style="color:white">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php
                                                if ($row['offer_1'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                <?php
                                                if ($row['offer_2'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                <?php
                                                if ($row['offer_3'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                <?php
                                                if ($row['offer_4'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                <?php
                                                if ($row['offer_5'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                <?php
                                                if ($row['offer_6'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                <?php
                                                if ($row['offer_7'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                <?php
                                                if ($row['offer_8'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                <?php
                                                if ($row['offer_9'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                <?php
                                                if ($row['offer_10'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>

                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="button">
                                    <?php if ($account_status == 0 || $contact_status == 0) { ?>
                                        <a href="#modal1">Order Now</a>
                                    <?php } else { ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="package_name" value="Gold"/>
                                            <input type="submit" value="Purchase Now" name="submit" class="btn btn-dark" />
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end of price tab-->
                        <!--price tab-->
                        <div class="col-sm-3 plan ultimite">
                            <div class="plan-inner">
                                <?php while ($row = $platinum->fetch_assoc()) { ?>
                                    <div class="entry-title">
                                        <h3><?php echo $row['package_name'] ?></h3>
                                        <div class="" style="color:white">
                                            <h3>$<?php echo $row['price_usd'] ?><span>/Month</span></h3>
                                            <h3><?php echo $row['price_taka'] ?> &nbsp;Taka<span>/Month</span></h3>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                        <ul>
                                            <li><?php echo $row['offer_1'] ?>
                                                <?php
                                                if ($row['offer_1'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_2'] ?>
                                                <?php
                                                if ($row['offer_2'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_3'] ?>
                                                <?php
                                                if ($row['offer_3'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_4'] ?>
                                                <?php
                                                if ($row['offer_4'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_5'] ?>
                                                <?php
                                                if ($row['offer_5'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_6'] ?>
                                                <?php
                                                if ($row['offer_6'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_7'] ?>
                                                <?php
                                                if ($row['offer_7'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_8'] ?>
                                                <?php
                                                if ($row['offer_8'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_9'] ?>
                                                <?php
                                                if ($row['offer_9'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>
                                            <li><?php echo $row['offer_10'] ?>
                                                <?php
                                                if ($row['offer_10'] == "") {
                                                    echo '<i class="fa fa-times"></i>';
                                                }
                                                ?>
                                            </li>

                                        </ul>
                                    <?php } ?>
                                </div>
                                <div class="button">
                                    <?php if ($account_status == 0 || $contact_status == 0) { ?>
                                        <a href="#modal1">Order Now</a>
                                    <?php } else { ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="package_name" value="Platinum"/>
                                            <input type="submit" value="Purchase Now" name="submit" class="btn btn-dark" />
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($account_status == 0 && $contact_status <> 0) { ?>

                            <!--modal-->
                            <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                                <center>
                                    <h3 class="modal-title">You have to verify your account first.</h3>
                                    <br>
                                    <a href="verify-account.php" class="btn btn-success">Verify Account</a>
                                </center>
                            </div>
                        <?php } elseif ($account_status <> 0 && $contact_status == 0) { ?>
                            <!--modal-->
                            <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                                <center>
                                    <h3 class="modal-title">You need to verify your contact first.</h3>
                                    <br>
                                    <a href="verify-contact.php" class="btn btn-primary">Verify Contact</a>
                                </center>
                            </div>
                        <?php } elseif ($account_status == 0 && $contact_status == 0) { ?>
                            <!--modal-->
                            <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                                <center>
                                    <h3 class="modal-title">Your account and contact is not verified.</h3>
                                    <br>
                                    <a href="verify-account.php" class="btn btn-success">Verify Account</a>
                                    &emsp;||&emsp;
                                    <a href="verify-contact.php" class="btn btn-primary">Verify Contact</a>
                                </center>
                            </div>
                        <?php } ?>
                        <!-- end of price tab-->
                    </div>
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>

    </body>
</html>