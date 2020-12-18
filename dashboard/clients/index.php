<?php
session_start();

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";
$message = "";
$server = new Client();
$result = $server->viewData();
$limit = $server->premium_data();
$active = $server->ViewActiveClients();

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
                        <div class="col-sm-12">
                            <div class="dash-widget" style="min-height: 110px">
                                <span class="dash-widget-bg1"><i class="fa fa-gift" aria-hidden="true"></i></span>
                                <div class="dash-widget-info text-right">
                                    <?php
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

                                    echo $message;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">TOP PROFILES</h4>
                                </div>
                                <div class="card-body p-0" style="min-height: 319px;max-height: 319px;overflow: auto">
                                    <div id="carousel3d">
                                        <carousel-3d :perspective="0" :space="200" :display="5" :controls-visible="true" :controls-prev-html="'❬'" :controls-next-html="'❭'" :controls-width="30" :controls-height="60" :clickable="true" :autoplay="true" :autoplay-timeout="5000">
                                            <?php
                                            $i = 0;
                                            while ($row = $featured->fetch_assoc()) {
                                                ?>
                                                <slide :index="<?php echo $i++; ?>">
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <img src="<?php echo $row['propic'] ?>" style="width:150px;height:150px"/>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <table style="text-align: justify; text-justify: inter-word;">
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
                                                                <tr>
                                                                    <td>Height:</td>
                                                                    <td><?php echo $row['height'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Weight:</td>
                                                                    <td><?php echo $row['weight'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <?php if ($payment_status == 0) { ?>
                                                                        <td colspan="2">
                                                                            <a href="#modal1"><button class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></button></a>
                                                                            <a href="#modal1"><button class="btn btn-success" title="Send Requst"><i class="fa fa-user-plus"></i></button></a>
                                                                            <a href="#modal1"><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></a>
                                                                            <a href="#modal1"><button class="btn btn-secondary" title="Like"><i class="fa fa-heart" style="color:red"></i></button></a>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td colspan="2">
                                                                            <form method="POST" action="">
                                                                                <?php if ($profile_viewed === $view_limit) { ?>
                                                                                    <a href="#modal3" class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>" class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></a>
                                                                                <?php } ?>
                                                                                <?php if ($row['client_id'] == $server->accepted($row['client_id']) || $client_id == $server->accepted($row['client_id'])) { ?>
                                                                                    <button class="btn btn-success" title="Connected One"><i class="fa fa-check" style="color:blueviolet;font-size: 20px"></i></button>
                                                                                <?php } elseif ($row['client_id'] == $server->request_status($row['client_id'])) { ?>
                                                                                    <a class="btn btn-success" title="Request Pending"><i class="fa fa-clock-o" style="color:blueviolet;font-size: 20px"></i></a>
                                                                                <?php } elseif ($request_sent === $request_limit) {
                                                                                    ?>
                                                                                    <a href="#modal" class="btn btn-success" title="Send Requst"><i class="fa fa-user-plus"></i></a>
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <input type="hidden" value="<?php echo $row['client_id'] ?>" name="request_to" />
                                                                                    <button type="submit" class="btn btn-success" title="Send Request" name="send"><i class="fa fa-user-plus"></i></button>
                                                                                <?php } ?>

                                                                                <?php if ($row['client_id'] == $server->accepted($row['client_id']) || $client_id == $server->accepted($row['client_id'])) { ?>
                                                                                    <a href="chat.php?message_to=<?php echo $row['client_id'] ?>"  class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="#modal2" class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></a>
                                                                                <?php } ?>
                                                                                <a href="#"><button class="btn btn-secondary" title="Like"><i class="fa fa-heart" style="color:red"></i></button></a>
                                                                            </form>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </slide>
                                            <?php } ?>
                                        </carousel-3d>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block text-success">Total active clients [ <?php echo $server->total_active_clients(); ?> ]</h4> <a href="all-clients.php" class="btn btn-primary float-right">View all</a>
                                </div>
                                <div class="card-body p-0" style="min-height: 319px;max-height: 319px;overflow: auto">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                if ($active->num_rows > 0) {
                                                    while ($row = $active->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a class="avatar"><img src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/></a>
                                                                <h2><a href="#"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?><span><?php echo $row['current_city'] ?>, <?php echo $row['current_country'] ?></span></a></h2>
                                                            </td>                 
                                                            <td>
                                                                <h5 class="time-title p-0">Gender</h5>
                                                                <p><?php echo $row['gender'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Age</h5>
                                                                <p><?php echo $row['age'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Religion</h5>
                                                                <p><?php echo $row['religion'] ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php if ($payment_status == 0) { ?>
                                                                    <a href="#modal1" class="btn btn-outline-primary take-btn">Take up</a>
                                                                <?php } elseif ($profile_viewed === $view_limit) { ?>
                                                                    <a href="#modal3" class="btn btn-outline-primary take-btn">Take up</a>
                                                                <?php } else { ?>
                                                                    <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>" class="btn btn-outline-primary take-btn">Take up</a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 200px;color: red;text-align: center" colspan="3">
                                                            <h2>No Active Clients Found !</h2>
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
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="card member-panel" >
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0">Add Section</h4>
                                </div>
                                <div class="card-body" style="height: 319px;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include './parts/messages.php'; ?>

                <!--modal-->
                <?php if ($request_sent === $request_limit) { ?>
                    <div class="awesome-modal" id="modal"><a class="close-icon" href="#close"></a>
                        <center>
                            <h3 class="modal-title text-danger">Sorry! You have reached your limit for sending request. Do you want to upgrade your limit?</h3>
                            <br>
                            <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                        </center>
                    </div>
                <?php } ?>

                <?php if ($payment_status == 0) { ?>
                    <div class="awesome-modal" id="modal1"><a class="close-icon" href="#close"></a>
                        <center>
                            <h3 class="modal-title text-danger">Sorry! You are not a premium user. Do you want to upgrade your profile?</h3>
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
                <?php if ($profile_viewed === $view_limit) { ?>
                    <div class="awesome-modal" id="modal3"><a class="close-icon" href="#close"></a>
                        <center>
                            <h3 class="modal-title text-danger">Sorry! You have reached your limit for visiting profile. Do you want to upgrade your limit?</h3>
                            <br>
                            <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                        </center>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>
        <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.7/vue.js'></script><script src='https://rawgit.com/Wlada/vue-carousel-3d/master/dist/vue-carousel-3d.min.js'></script>
        <script >new Vue({
                el: '#carousel3d',
                data: {
                    slides: 7
                },
                components: {
                    'carousel-3d': Carousel3d.Carousel3d,
                    'slide': Carousel3d.Slide
                }
            })
            //# sourceURL=pen.js
        </script>
    </body>
</html>