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
$output = $server->sent_requests();
$data = $server->received_requests();

if (isset($_POST['cancel'])) {
    $message = $server->cancel_request($_POST);
}

if (isset($_POST['accept'])) {
    $message = $server->accept_requestPOST($_POST);
}
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
                if ($row['gender'] == 'Male') {
                    $featured = $server->featured_FemaleProfiles();
                } elseif ($row['gender'] == 'Female') {
                    $featured = $server->featured_MaleProfiles();
                }
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
                            <h4 class="page-title"><u>Client Profile</u><?php echo $message; ?></h4>
                        </div>
                        <div class="col-sm-6 col-9 text-right m-b-20">
                            <a href="all-clients.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-users"></i> All Clients</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block text-danger">Sent Requests [ <?php echo $server->total_sent_requests(); ?> ]</h4>
                                </div>
                                <div class="card-body p-0" style="min-height: 450px;max-height: 450px;overflow: auto">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                if ($output->num_rows > 0) {
                                                    while ($row = $output->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a href="client-profile.php?client_id=<?php echo $row['request_to'] ?>" class="avatar"><img src="<?php echo $server->clientIamge_byID($row['request_to']) ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/></a>
                                                                <h2><a href="client-profile.php?client_id=<?php echo $row['request_to'] ?>"><?php echo $server->clientName_byID($row['request_to']) ?></a></h2>
                                                            </td>                 
                                                            <td>
                                                                <h5 class="time-title p-0">Requested At</h5>
                                                                <p><?php echo $row['request_date'] ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <form method="POST" action="" >
                                                                    <input type="hidden" value="<?php echo $row['request_to'] ?>" name="client_id" />
                                                                    <button type="submit" class="btn btn-outline-danger take-btn" title="Cancel Request" name="cancel" onclick="return confirm('Are you sure to cancel?');">Remove</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 200px;color: red;text-align: center" colspan="3">
                                                            <h2>No Sent Request Found !</h2>
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
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block text-success">Received Requests [ <?php echo $server->total_received_requests(); ?> ]</h4>
                                </div>
                                <div class="card-body p-0" style="min-height: 450px;max-height: 450px;overflow: auto">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                if ($data->num_rows > 0) {
                                                    while ($row = $data->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php if ($payment_status == 0) { ?>
                                                                    <a href="#modal1" class="avatar"><img src="<?php echo $server->clientIamge_byID($row['request_from']) ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/></a>
                                                                    <h2><a href="#modal1"><?php echo $server->clientName_byID($row['request_from']) ?></a></h2>

                                                                <?php } else { ?>
                                                                    <a href="client-profile.php?client_id=<?php echo $row['request_from'] ?>" class="avatar"><img src="<?php echo $server->clientIamge_byID($row['request_from']) ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/></a>
                                                                    <h2><a href="client-profile.php?client_id=<?php echo $row['request_from'] ?>"><?php echo $server->clientName_byID($row['request_from']) ?></a></h2>

                                                                <?php } ?>
                                                            </td>                 
                                                            <td>
                                                                <h5 class="time-title p-0">Requested At</h5>
                                                                <p><?php echo $row['request_date'] ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if ($payment_status == 0) { ?>
                                                                    <a href="#modal1" class=""><button type="button" class="btn btn-outline-success take-btn" title="Accept Request" name="accept">Accept</button></a>
                                                                    <a href="#modal1" class=""><button type="button" class="btn btn-outline-danger take-btn" title="Cancel Request" name="cancel">Remove</button></a>
                                                                <?php } else { ?>
                                                                    <form method="POST" action="">
                                                                        <input type="hidden" value="<?php echo $row['request_from'] ?>" name="client_id" />
                                                                        <button type="submit" class="btn btn-outline-success take-btn" title="Accept Request" name="accept">Accept</button>

                                                                        <input type="hidden" value="<?php echo $row['request_from'] ?>" name="client_id" />
                                                                        <button type="submit" class="btn btn-outline-danger take-btn" title="Cancel Request" name="cancel" onclick="return confirm('Are you sure to cancel?');">Remove</button>
                                                                    </form>
                                                                <?php } ?>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 200px;color: red;text-align: center" colspan="3">
                                                            <h2>No Received Request Found !</h2>
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