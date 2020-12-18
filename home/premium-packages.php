<?php
require_once './server/Home.php';

$server = new Home();

$bronze = $server->package_bronze();
$silver = $server->package_silver();
$gold = $server->package_gold();
$platinum = $server->package_platinum();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include './parts/head.php'; ?>
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
        <!--heading part start-->
        <?php include './parts/menu.php'; ?>

        <!--profile part start-->
        <section class="payment-package">
            <div id="price" class="row">
                <!--price tab-->
                <div class="col-sm-3 plan">
                    <div class="plan-inner">
                        <?php while ($row = $bronze->fetch_assoc()) { ?>
                            <div class="entry-title" style="background-color: #cd7f32">
                                <h2 style="background-color: #cd7f32;"><u><?php echo $row['package_name'] ?></u></h2>
                                <div>
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
                            <a href="#modal1">Get Premium</a>
                        </div>
                    </div>
                </div>
                <!-- end of price tab-->
                <!--price tab-->
                <div class="col-sm-3 plan basic">
                    <div class="plan-inner">
                        <?php while ($row = $silver->fetch_assoc()) { ?>
                            <div class="entry-title" style="background-color: #D3D3D3;color:black">
                                <h2 style="background-color: #D3D3D3;"><u><?php echo $row['package_name'] ?></u></h2>
                                <div>
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
                            <a href="#modal1">Get Premium</a>
                        </div>
                    </div>
                </div>
                <!-- end of price tab-->
                <!--price tab-->
                <div class="col-sm-3 plan standard">
                    <div class="plan-inner">
                        <div class="hot">hot</div>
                        <?php while ($row = $gold->fetch_assoc()) { ?>
                            <div class="hot">hot</div>
                            <div class="entry-title" style="background-color: #FFD700;color:green">
                                <h2 style="background-color: #FFD700;"><u><?php echo $row['package_name'] ?></u></h2>
                                <div >
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
                            <a href="#modal1">Get Premium</a>
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
                            <a href="#modal1">Get Premium</a>
                        </div>
                    </div>
                </div>

                <div class="awesome-modal" id="modal1" style="font-family: 'Titillium Web', sans-serif !important;">
                    <a class="close-icon" href="#close"></a>
                    <center>
                        <h4 class="modal-title text-danger">Sorry! you are not logged in.Please login your account first.</h4>
                        <br>
                        <a href="../login/client/" class="btn btn-success" style="width:100px">Login</a>
                        &emsp;||&emsp;
                        <a href="../registration/client/" class="btn btn-primary">Register</a>
                    </center>
                </div>


            </div>
        </section>
        <!--profile part end-->
        
        <!-- contract-part end-->
        <!-- footer-part start-->
        <?php include './parts/footer.php'; ?>
        <!-- footert-part end-->
        <?php include './parts/js-links.php'; ?>
    </body>
</html>