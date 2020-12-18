<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header('location:logout.php');
    exit;
}

session_start();


$client_id = $_SESSION['client_id'];
$_SESSION['message_to'] = $_GET['message_to'];


if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$conn = new mysqli('localhost', 'root', '', 'matrimony');


require_once './server/Client.php';
$message = "";

$server = new Client();
$result = $server->viewData();
$output = $server->requested_ones();
$data   = $server->accepted_ones();
$limit = $server->premium_data();
$chats = $server->chat_data();

$seen = $server->message_seen($_GET['message_to']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            .sidebar, .page-wrapper{
                font-family: 'Titillium Web', sans-serif;
            }

            .cont{
                overflow-x: hidden;
                overflow-y: auto;
                transform: rotate(180deg);
                text-align:left;
            }
            .ul{
                overflow: hidden;
                transform: rotate(180deg);
            }
        </style>
    </head>

    <body>
        <div class="main-wrapper" >
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
                <?php
            }
            if ($limit->num_rows > 0) {
                while ($row = $limit->fetch_assoc()) {
                    $message_limit = $row['message_limit'];
                    $message_sent = $row['message_sent'];
                    $validate_to = $row['validate_datetime'];
                    $view_limit = $row['view_limit'];
                    $profile_viewed = $row['profile_viewed'];
                }
            } else {
                $message_limit = "";
                $message_sent = "";
                $view_limit = "";
                $profile_viewed = "";
            }
            ?>
            <div class="sidebar" id="sidebar" >
                <div class="sidebar-inner slimscroll">
                    <div class="sidebar-menu" id="unseen_to">
                        <ul>
                            <li>
                                <a href="index.php"><i class="fa fa-home back-icon"></i> <span>Back to Home</span></a>
                            </li>
                            <li class="menu-title">Connected Ones <a href="#" class="add-user-icon" ><i class="fa fa-users"></i></a></li>
                            <?php
                            while ($row = $output->fetch_assoc()) {
                                ?>
                                <li>
                                    <a href="chat.php?message_to=<?php echo $row['request_to'] ?>"><span class="chat-avatar-sm user-img">
                                            <img src="<?php echo $server->clientIamge_byID($row['request_to']) ?>" alt=""  class="rounded-circle" style="height: 30px;width: 30px">
                                            <?php echo $server->is_active($row['request_to']) ?></span> <?php echo $server->clientName_byID($row['request_to']) ?>
                                        <span class="badge badge-pill bg-danger float-right"  style="font-size: 12px">
                                            <?php
                                            $receiver = $_SESSION['client_id'];
                                            $sender = $row['request_to'];

                                            $sql = "SELECT COUNT(id) FROM `chats` WHERE message_from ='$sender' AND message_to = '$receiver' AND is_seen = 0 ";

                                            $result = mysqli_query($conn, $sql);
                                            $rows = mysqli_fetch_row($result);
                                            $count = $rows[0];
                                            echo $count;
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php
                            while ($row = $data->fetch_assoc()) {
                                ?>
                                <li>
                                    <a href="chat.php?message_to=<?php echo $row['request_from'] ?>"><span class="chat-avatar-sm user-img">
                                            <img src="<?php echo $server->clientIamge_byID($row['request_from']) ?>" alt="" class="rounded-circle" style="height: 25px;width: 25px">
                                            <?php echo $server->is_active($row['request_from']) ?> </span><?php echo $server->clientName_byID($row['request_from']) ?>
                                        <span class="badge badge-pill bg-danger float-right" id=" " style="font-size: 12px">
                                            <?php
                                            $receiver = $_SESSION['client_id'];
                                            $sender = $row['request_from'];

                                            $sql = "SELECT COUNT(id) FROM `chats` WHERE message_from ='$sender' AND message_to = '$receiver' AND is_seen = 0 ";

                                            $result = mysqli_query($conn, $sql);
                                            $rows = mysqli_fetch_row($result);
                                            $count = $rows[0];
                                            echo $count;
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php echo $message; ?>
                    </div>
                </div>
            </div>
            <div class="page-wrapper">
                <div class="chat-main-row">
                    <div class="chat-main-wrapper">
                        <div class="col-lg-9 message-view chat-view">
                            <div class="chat-window">
                                <div class="fixed-header">
                                    <div class="navbar">
                                        <?php if ($profile_viewed === $view_limit) { ?>
                                            <div class="user-details mr-auto">
                                                <div class="float-left user-img m-r-10">
                                                    <a href="#modal" title=""><img src="<?php echo $server->clientIamge_byID($_GET['message_to']) ?>" alt="" class="w-40 rounded-circle" style="height:40px;width: 40px">
                                                        <?php echo $server->is_active($_GET['message_to']) ?>
                                                    </a>
                                                </div>
                                                <div class="user-info float-left">
                                                    <a href="#modal"><span class="font-bold"><?php echo $server->clientName_byID($_GET['message_to']) ?></span></a>
                                                    <span class="last-seen">Last seen at <?php echo $server->last_activity($_GET['message_to']) ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="user-details mr-auto">
                                                <div class="float-left user-img m-r-10">
                                                    <a href="client-profile.php?client_id=<?php echo $_GET['message_to'] ?>" title=""><img src="<?php echo $server->clientIamge_byID($_GET['message_to']) ?>" alt="" class="w-40 rounded-circle" style="height:40px;width: 40px">
                                                        <?php echo $server->is_active($_GET['message_to']) ?>
                                                    </a>
                                                </div>
                                                <div class="user-info float-left">
                                                    <a href="client-profile.php?client_id=<?php echo $_GET['message_to'] ?>"><span class="font-bold"><?php echo $server->clientName_byID($_GET['message_to']) ?></span></a>
                                                    <span class="last-seen">Last seen at <?php echo $server->last_activity($_GET['message_to']) ?></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <ul class="nav custom-menu">
                                            <li class="nav-item dropdown dropdown-action">
                                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <form method="POST" accept-charset="chat.php?message_to=<?php echo $_GET['message_to']; ?>">
                                                        <input type="hidden" name="" value="<?php echo $_GET['message_to']; ?>"/>
                                                        <button class="dropdown-item text-danger" type="submit" style="cursor: pointer;background: none;border: none;outline: none" >
                                                            <i class="fa fa-ban"></i>&emsp; Block This Person 
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chat-contents cont" >
                                    <div class="chat-content-wrap">
                                        <div class="chat-wrap-inner">
                                            <div class="chat-box" >
                                                <div class="chats ul" >
                                                    <div id="chat">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($profile_viewed === $view_limit) { ?>
                                    <div class="awesome-modal" id="modal"><a class="close-icon" href="#close"></a>
                                        <center>
                                            <h3 class="modal-title text-danger">Sorry! You have reached your limit for visiting profile. Do you want to upgrade your limit?</h3>
                                            <br>
                                            <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                                        </center>
                                    </div>
                                <?php } ?>

                                <?php
                                $expired = $server->package_expiration();

                                if ($expired === 1) {
                                    echo "<script type='text/javascript'>alert('Sorry! Your package is expired! Please renew or upgrade your package to continue. ');document.location='premium-packages.php';</script>";
                                } elseif ($message_sent === $message_limit) {
                                    ?>
                                    <div class="chat-footer" style="">
                                        <div class="message-bar">
                                            <div class="message-inner">
                                                <center>
                                                    <center>
                                                        <h4 class="text-danger">
                                                            Sorry! You have reached your limit for messages. Please <a href="premium-packages.php">renew or upgrade</a> your package to continue. <br>
                                                        </h4>
                                                    </center>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {

                                    if (isset($_POST['send'])) {
                                        $message = $server->send_message($_POST);
                                    }
                                    ?>

                                    <iframe name="frame" style="display:none;"></iframe>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="frame">
                                        <div class="chat-footer" style="">
                                            <div class="message-bar">
                                                <div class="message-inner">
                                                    <div class="">
                                                        <div class="input-group">
                                                            <input type="hidden" name="message_to" value="<?php echo $_GET['message_to'] ?>"/>
                                                            <textarea class="form-control" placeholder="Type message..." name="message" required><?php echo $message; ?></textarea>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-primary" type="submit" name="send"  onclick='setTimeout("location.reload(true);", 100);'><i class="fa fa-send"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                            <div class="chat-window video-window">
                                <div class="fixed-header">
                                    <ul class="nav nav-tabs nav-tabs-bottom">
                                        <li class="nav-item"><a class="nav-link active" href="#profile_tab" data-toggle="tab">Profile</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content chat-contents">
                                    <div class="content-full tab-pane show active" id="profile_tab">
                                        <div class="display-table">
                                            <div class="table-row">
                                                <div class="table-body">
                                                    <div class="table-content">
                                                        <div class="chat-profile-img">
                                                            <div class="edit-profile-img">
                                                                <img src="<?php echo $server->clientIamge_byID($_GET['message_to']) ?>" style="height:120px;width: 120px" alt="">
                                                            </div>
                                                            <h3 class="user-name m-t-10 mb-0"><?php echo $server->clientName_byID($_GET['message_to']) ?></h3>
                                                        </div>
                                                        <div class="chat-profile-info">
                                                            <ul class="user-det-list">
                                                                <li>
                                                                    <span><b>Total Messages</b></span>
                                                                    <span class="float-right text-muted"></span>
                                                                </li>
                                                                <li>
                                                                    <span>Sent Messages:</span>
                                                                    <span class="float-right text-danger" id="sent">
                                                                        <?php
                                                                        $receiver = $_GET['message_to'];

                                                                        $sql = "SELECT COUNT(id) FROM `chats` WHERE message_from ='$client_id' AND message_to = '$receiver' ";

                                                                        $result = mysqli_query($conn, $sql);
                                                                        $rows = mysqli_fetch_row($result);
                                                                        $count = $rows[0];
                                                                        echo $count;
                                                                        ?>
                                                                    </span>
                                                                </li>
                                                                <li>
                                                                    <span>Received Messages:</span>
                                                                    <span class="float-right text-danger" id="received">
                                                                        <?php
                                                                        $sender = $_GET['message_to'];

                                                                        $sql = "SELECT COUNT(id) FROM `chats` WHERE message_from ='$sender' AND message_to = '$client_id' ";

                                                                        $result = mysqli_query($conn, $sql);
                                                                        $rows = mysqli_fetch_row($result);
                                                                        $count = $rows[0];
                                                                        echo $count;
                                                                        ?>
                                                                    </span>
                                                                </li>
                                                                <hr>
                                                                <li style="font-size: 15px">
                                                                    <span>Message Left:</span>
                                                                    <span class="float-right text-danger" >
                                                                        <?php
                                                                        if ($expired === 1) {
                                                                            echo 'Expired';
                                                                        } elseif ($message_limit === '500000') {
                                                                            echo 'Unlimited';
                                                                        } else {
                                                                            echo $remain = $message_limit - $message_sent;
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </li>
                                                                <li style="font-size: 15px">
                                                                    <span>Validate to:</span>
                                                                    <span class="float-right text-danger" >
                                                                        <?php
                                                                        if ($expired === 1) {
                                                                            echo 'Expired';
                                                                        } else {
                                                                            echo $validate_to;
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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