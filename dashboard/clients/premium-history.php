<?php
session_start();

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$message = "";

$server = new Client();
$result = $server->viewData();
$output = $server->all_premium_data();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style class="cp-pen-styles">#carousel3d .carousel-3d-slide {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-flex: 1;
                -ms-flex: 1;
                flex: 1;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                text-align: center;
                background-color: #fff;
                padding: 10px;
                -webkit-transition: all .4s;
                transition: all .4s;
            }
            #carousel3d .carousel-3d-slide.current {
                background-color: #333;
                color: #fff;
            }
            #carousel3d .carousel-3d-slide.current span {
                font-size: 20px;
                font-weight: 500;
            }
        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
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
                        <div class="col-sm-6 col-3">
                            <h4 class="page-title"><u>Premium History</u></h4>
                        </div>
                        <div class="col-sm-6 col-9 text-right m-b-20">
                            <a href="premium-packages.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Upgrade Package</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block text-danger">Package Data Table</h4>
                                </div>
                                <div class="card-body p-0" style="min-height: 450px;max-height: 450px;overflow: auto">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                if ($output->num_rows > 0) {
                                                    while ($row = $output->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <h5 class="time-title p-0">Serial No</h5>
                                                                <p><?php echo $i++; ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Package Name</h5>
                                                                <p><?php echo $row['package_name'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Purchase Date</h5>
                                                                <p><?php echo $row['initiated_datetime'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Validate To</h5>
                                                                <p><?php echo $row['validate_datetime'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Request Left</h5>
                                                                <p class="text-danger"><?php echo $left = $row['request_limit'] - $row['request_sent'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Visit Left</h5>
                                                                <p class="text-danger"><?php echo $left = $row['view_limit'] - $row['profile_viewed'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Message Left</h5>
                                                                <p class="text-danger"><?php echo $left = $row['message_limit'] - $row['message_sent'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Status</h5>
                                                                <p><?php
                                                                    if ($row['status'] == 0) {
                                                                        echo '<span class="text-danger">Expired</span>';
                                                                    } elseif ($row['status'] == 1) {
                                                                        echo '<span class="text-success"><b>Running</b></span>';
                                                                    }
                                                                    ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 200px;color: red;text-align: center" colspan="8">
                                                            <h2>No Data Found !</h2>
                                                        </td>                 
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include './parts/messages.php'; ?>

                <!--modal-->

                <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                    <center>
                        <h3 class="modal-title text-danger">Sorry! You are not a premium user. Do you want to upgrade your profile?</h3>
                        <br>
                        <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                    </center>
                </div>
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>

    </body>
</html>