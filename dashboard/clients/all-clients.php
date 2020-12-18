<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";
$output = "";
$message= "";

$server = new Client();
$result = $server->viewData();


$output = $server->all_clients();
$limit = $server->premium_data();

if (isset($_POST['send'])) {
    $message = $server->send_request($_POST);
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
            .content{
                font-family: 'Titillium Web', sans-serif !important;
            }

            button{
                width: 60px
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
                <?php
            }
            if ($limit->num_rows > 0) {
                while ($row = $limit->fetch_assoc()) {
                    $request_limit = $row['request_limit'];
                    $request_sent = $row['request_sent'];
                    $view_limit = $row['view_limit'];
                    $profile_viewed = $row['profile_viewed'];
                }
            } else {
                $request_limit = "";
                $request_sent = "";
                $view_limit = "";
                $profile_viewed = "";
            }
            ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                <u>All PROFILES</u>&nbsp;<i class="fa fa-users"></i><?php echo $message; ?>
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-primary btn-rounded float-right" href="search.php">
                                <i class="fa fa-search"></i>&nbsp;Search
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if ($output->num_rows > 0) {
                            while ($row = $output->fetch_assoc()) {
                                ?>
                                <div class="card col-sm-12" style="min-height: 190px;padding-top: 2%"> 

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img style="height: 150px;width:150px" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="">
                                        </div>
                                        <div class="col-sm-3">
                                            <h4><b>Basic Info</b></h4>
                                            <table>
                                                <tr>
                                                    <td>Name:</td>
                                                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Country:</td>
                                                    <td><?php echo $row['current_country'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>City:</td>
                                                    <td><?php echo $row['current_city'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Marital Status:</td>
                                                    <td><?php echo $row['marital_status'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Religion:</td>
                                                    <td><?php echo $row['religion'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-2">
                                            <h4></h4><br>
                                            <table>
                                                <tr>
                                                    <td>Gender:</td>
                                                    <td><?php echo $row['gender'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Age:</td>
                                                    <td><?php echo $row['age'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Height:</td>
                                                    <td><?php echo $row['height'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Weight</td>
                                                    <td><?php echo $row['weight'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4><b>Biography</b></h4>
                                            <?php
                                            if ($payment_status == 0) {
                                                $string = $row['biography'];
                                                if (strlen($string) > 100) {
                                                    $trimstring = substr($string, 0, 100) . ' <a href="#modal1' . $a++ . '">read more...</a>';
                                                } else {
                                                    $trimstring = $string;
                                                }
                                                echo $trimstring;
                                            } else {
                                                $string = $row['biography'];
                                                if (strlen($string) > 100) {
                                                    $trimstring = substr($string, 0, 100) . ' <a href="#">read more...</a>';
                                                } else {
                                                    $trimstring = $string;
                                                }
                                                echo $trimstring;
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-1">
                                            <table>
                                                <?php if ($payment_status == 0) { ?>
                                                    <tr>
                                                        <td><a href="#modal1" ><button class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-success" title="Send Requst"><i class="fa fa-user-plus"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-secondary" title="Like"><i class="fa fa-heart" style="color:red"></i></button></a></td>
                                                    </tr>
                                                <?php } else { ?>

                                                    <tr>
                                                        <td>
                                                            <?php if ($profile_viewed === $view_limit) { ?>
                                                                <a href="#modal3">
                                                                    <button class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></button>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>">
                                                                    <button class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></button>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php if ($row['client_id'] == $server->accepted($row['client_id']) || $client_id == $server->accepted($row['client_id'])) { ?>
                                                                <button class="btn btn-success" title="Connected One"><i class="fa fa-check" style="color:blueviolet;font-size: 20px"></i></button>
                                                            <?php } elseif ($row['client_id'] == $server->request_status($row['client_id'])) { ?>
                                                                <button class="btn btn-success" title="Request Pending"><i class="fa fa-clock-o" style="color:blueviolet;font-size: 20px"></i></button>
                                                            <?php } elseif ($request_sent === $request_limit) {
                                                                ?>
                                                                <a href="#modal"><button class="btn btn-success" title="Send Request"><i class="fa fa-user-plus"></i></button></a>
                                                            <?php } else { ?>
                                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                                                    <input type="hidden" value="<?php echo $row['client_id'] ?>" name="request_to" />
                                                                    <button type="submit" class="btn btn-success" title="Send Request" name="send"><i class="fa fa-user-plus"></i></button>
                                                                </form>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php if ($row['client_id'] == $server->accepted($row['client_id']) || $client_id == $server->accepted($row['client_id'])) { ?>
                                                                <a href="chat.php?message_to=<?php echo $row['client_id'] ?>"><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></a>
                                                            <?php } else { ?>
                                                                <a href="#modal2"><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><button class="btn btn-secondary" title="Like"><i class="fa fa-heart" style="color:red"></i></button></td>
                                                    </tr>

                                                <?php } ?>
                                            </table>

                                            <?php if ($payment_status == 0) { ?>
                                                <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                                                    <center>
                                                        <h3 class="modal-title text-danger">Sorry! You are not a premium user. Do you want to upgrade your profile?</h3>
                                                        <br>
                                                        <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                                                    </center>
                                                </div>
                                            <?php } ?>

                                            <?php if ($request_sent === $request_limit) { ?>
                                                <div class="awesome-modal" id="modal"><a class="close-icon" href="#close"></a>
                                                    <center>
                                                        <h3 class="modal-title text-danger">Sorry! You have reached your limit for sending request. Do you want to upgrade your profile?</h3>
                                                        <br>
                                                        <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                                                    </center>
                                                </div>
                                            <?php } ?>
                                            <?php if ($profile_viewed === $view_limit) { ?>
                                                <div class="awesome-modal" id="modal3"><a class="close-icon" href="#close"></a>
                                                    <center>
                                                        <h3 class="modal-title text-danger">Sorry! You have reached your limit for visiting profile. Do you want to upgrade your limit?</h3>
                                                        <br>
                                                        <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                                                    </center>
                                                </div>
                                            <?php } ?>
                                            <div class="awesome-modal" id="modal2"><a class="close-icon" href="#close"></a>
                                                <center>
                                                    <h3 class="modal-title text-danger">Sorry! You are not connected with this person.</h3>
                                                    <br>
                                                </center>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="card col-md-12 col-sm-12  col-lg-12">
                                <center>
                                    <img alt="" src="../gallery/nodata-found.png" alt="" style="height: 100%;width: 100%">
                                </center>
                            </div>
                        <?php }
                        ?>
                        <?php include './parts/messages.php'; ?>
                    </div>
                </div>
                <div class="sidebar-overlay" data-reff=""></div>
            </div>
        </div>
        
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
        
        <?php if ($payment_status == 0) { ?>
            <script>
                $('img').bind('contextmenu', function (e) {
                    return false;
                });
            </script>
        <?php } ?>


    </body>
</html>