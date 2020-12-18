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
    $error = $server->accountVarification_nid($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            .content{
                font-family: 'Titillium Web', sans-serif;
            }

        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
                $account_status = $row['account_status'];
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
                        <div class="col-sm-4">
                            <h4 class="page-title"><u>NID Verification</u>&nbsp;
                                <i class="fa fa-check-circle" style="color:<?php
                                if ($account_status == 0) {
                                    echo'red';
                                } else {
                                    echo 'green';
                                }
                                ?>"></i>
                            </h4>
                        </div>
                        <div class="col-sm-8">
                            <h4 style="color:red"><?php echo $error; ?></h4>
                        </div>
                    </div>
                    <?php
                    if ($account_status == 0) {
                        ?>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6 card-box" style="min-height:250px">
                                    <center>
                                        <h4 class="modal-title">Upload Front Side</h4>
                                        <small style="color:red">Upload a clear photo. Follow the example.</small>
                                        <div style="min-height: 180px;width: 300px;border:1px solid;border-radius: 5px">
                                            <img id="front" alt="" width="298" height="198" src="" onerror="this.onerror=null; this.src='../gallery/NID/example/front.jfif'"/>
                                        </div>
                                        <div class="fileupload btn">
                                            <span class="btn-text">upload front</span>
                                            <input class="upload" type="file" 
                                                   onchange="document.getElementById('front').src = window.URL.createObjectURL(this.files[0])" name="nid_front" required>
                                        </div>
                                    </center>
                                </div>
                                <div class="col-sm-6 card-box" style="min-height:250px">
                                    <center>
                                        <h4 class="modal-title">Upload Back Side</h4>
                                        <small style="color:red">Upload a clear photo. Follow the example.</small>
                                        <div style="min-height: 180px;width: 300px;border:1px solid;border-radius: 5px">
                                            <img id="back" alt="" width="298" height="198" src="" onerror="this.onerror=null; this.src='../gallery/NID/example/back.jpg'" />
                                        </div>
                                        <div class="fileupload btn">
                                            <span class="btn-text">upload back</span>
                                            <input class="upload" type="file" 
                                                   onchange="document.getElementById('back').src = window.URL.createObjectURL(this.files[0])" name="nid_back" required>
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <center>
                                <input type="submit" class="btn btn-primary btn-group-lg" name="submit" style="height: 60px;width:200px;font-size: 20px" name value="Send Request" />
                            </center>

                        </form>
                    <?php } else { ?>
                        <script>
                            window.location.replace("verify-account.php");
                        </script>
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