<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";


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

                    <div class="card col-md-12 col-sm-12  col-lg-12">
                        <center>
                            <img alt="" src="../gallery/nodata-found.png" alt="" style="height: 100%;width: 100%">
                        </center>

                    </div>

                    <?php include './parts/messages.php'; ?>
                </div>
            </div>
            <div class="sidebar-overlay" data-reff=""></div>
        </div>

        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
        
        <script>
            $('img').bind('contextmenu', function (e) {
                return false;
            });
        </script>

    </body>
</html>