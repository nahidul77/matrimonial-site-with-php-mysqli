<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './server/Client.php';
$result = "";
$output = "";
$message = "";

$server = new Client();
$result = $server->viewData();
$data = $server->getClientData();
$increase = $server->increase_view();
$visited = $server->be_visitor();
$limit = $server->premium_data();
$phone = $server->phone_request_status();
$email = $server->email_request_status();

if (isset($_POST['request'])) {
    $message = $server->send_contact_request($_POST);
}

if (isset($_POST['send'])) {
    $message = $server->send_request($_POST);
}

if (isset($_POST['cancel'])) {
    $message = $server->cancel_request($_POST);
}

if (isset($_POST['accept'])) {
    $message = $server->accept_requestGET();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            label, h3{
                font-family: 'Rajdhani', sans-serif !important;
                font-weight: bolder !important;
                text-transform: uppercase
            }
            .content{
                font-family: 'Titillium Web', sans-serif;
            }
            .button{
                background: none;outline: none;border:none;color:blue;cursor: pointer;
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
            while ($row = $limit->fetch_assoc()) {
                $request_limit = $row['request_limit'];
                $request_sent  = $row['request_sent'];
            }
            ?>

            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6 col-3">
                            <h4 class="page-title"><u>Client Profile</u> <?php echo $message; ?></h4>
                        </div>
                        <div class="col-sm-6 col-9 text-right m-b-20">
                            <a href="all-clients.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-users"></i> All Clients</a>
                        </div>
                    </div>
                    <?php
                    while ($row = $data->fetch_assoc()) {
                        ?>
                        <div class="card-box profile-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap" >
                                            <div class="profile-img">
                                                <a href="<?php echo $row['propic'] ?>" target="_blank"><img class="" src="<?php echo $row['propic'] ?>"  onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="">
                                                        <h3 class="user-name m-t-0 mb-0"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h3>
                                                    </div>
                                                    <br>
                                                    <?php if ($row['client_id'] == $server->mutual($row['client_id']) || $client_id == $server->mutual($row['client_id'])) { ?>
                                                        <button class="btn btn-success" title="Connected" style="width: 135px"><i class="fa fa-check-circle" style="color:blueviolet;font-size: 20px"></i>&nbsp;Connected</button>
                                                        <a href="chat.php?message_to=<?php echo $row['client_id'] ?>">
                                                            <button class="btn btn-primary" title="Send Message" style="width: 135px"><i class="fa fa-envelope" style="color:yellow;font-size: 20px"></i>&nbsp;Send Message</button>
                                                        </a>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['client_id'] ?>" name="client_id" />
                                                            <button type="submit" class="btn btn-danger" title="Remove" name="cancel" style="width: 135px" onclick="return confirm('Are you sure to cancel?');"><i class="fa fa-user-times"></i>&nbsp;Remove</button>
                                                        </form>

                                                    <?php } elseif ($row['client_id'] == $server->accept_button($row['client_id'])) { ?>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['client_id'] ?>" name="request_to" />
                                                            <button type="submit" class="btn btn-success" title="Accept Request" name="accept"><i class="fa fa-check-circle"></i>&nbsp;Accept Request</button>
                                                        </form>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['client_id'] ?>" name="client_id" />
                                                            <button type="submit" class="btn btn-danger" title="Cancel Request" name="cancel" onclick="return confirm('Are you sure to cancel?');"><i class="fa fa-user-times"></i>&nbsp;Cancel Request</button>
                                                        </form>
                                                    <?php } elseif ($row['client_id'] == $server->request_status($row['client_id'])) { ?>
                                                        <button class="btn btn-success" title="Request Pending" style="width: 135px"><i class="fa fa-clock-o" style="color:blueviolet;font-size: 20px"></i>&nbsp;Request Sent</button>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['client_id'] ?>" name="client_id" />
                                                            <button type="submit" class="btn btn-danger" title="Cancel Request" name="cancel" onclick="return confirm('Are you sure to cancel?');"><i class="fa fa-user-times"></i>&nbsp;Cancel Request</button>
                                                        </form>
                                                    <?php } elseif ($request_sent === $request_limit) { ?>
                                                        <a href="#modal" class="btn btn-success" title="Send Requst"><i class="fa fa-user-plus"></i>Send Request</a>
                                                    <?php } else { ?>
                                                        <form method="POST" action="">
                                                            <input type="hidden" value="<?php echo $row['client_id'] ?>" name="request_to" />
                                                            <button type="submit" class="btn btn-success" title="Send Request" name="send"><i class="fa fa-user-plus"></i>Send Request</button>
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <span class="title">Phone:</span>
                                                            <span class="text"><a href="#"><?php echo $row['phone'] ?></a></span>
                                                            <?php
                                                            if ($row['phone'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Email:</span>
                                                            <span class="text"><a href="mailto:<?php echo $row['email'] ?>?Subject=" target="_top"><?php echo $row['email'] ?></a></span>
                                                            <?php
                                                            if ($row['email'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Birthday:</span>
                                                            <span class="text"><?php echo $row['birthday'] ?></span>
                                                            <?php
                                                            if ($row['birthday'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Gender:</span>
                                                            <span class="text"><?php echo $row['gender'] ?></span>
                                                            <?php
                                                            if ($row['gender'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Religion:</span>
                                                            <span class="text"><?php echo $row['religion'] ?></span>
                                                            <?php
                                                            if ($row['religion'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Contact Info</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">Education & Career</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab4" data-toggle="tab">Physical Attribute</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab5" data-toggle="tab">Biography</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="about-cont">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Personal Information</h3>
                                                <ul class="personal-info">

                                                    <li>
                                                        <span class="title">Marital Status:</span>
                                                        <span class="text"><?php echo $row['marital_status'] ?></span>
                                                        <?php
                                                        if ($row['marital_status'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Nationality:</span>
                                                        <span class="text"><?php echo $row['nationality'] ?></span>
                                                        <?php
                                                        if ($row['nationality'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Interested in:</span>
                                                        <span class="text"><?php echo $row['interest'] ?></span>
                                                        <?php
                                                        if ($row['interest'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Hobby:</span>
                                                        <span class="text"><?php echo $row['hobby'] ?></span>
                                                        <?php
                                                        if ($row['hobby'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Age:</span>
                                                        <span class="text"><?php echo $row['age'] ?></span>
                                                        <?php
                                                        if ($row['age'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Blood Group:</span>
                                                        <span class="text"><?php echo $row['blood_group'] ?></span>
                                                        <?php
                                                        if ($row['blood_group'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Smoking Habit:</span>
                                                        <span class="text"><?php echo $row['smoking'] ?></span>
                                                        <?php
                                                        if ($row['smoking'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Family Information</h3>
                                                <ul class="personal-info">

                                                    <li>
                                                        <span class="title">Father's Name:</span>
                                                        <span class="text"><?php echo $row['father_name'] ?></span>
                                                        <?php
                                                        if ($row['father_name'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Mother's Name:</span>
                                                        <span class="text"><?php echo $row['mother_name'] ?></span>
                                                        <?php
                                                        if ($row['mother_name'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Father's Status:</span>
                                                        <span class="text"><?php echo $row['father_status'] ?></span>
                                                        <?php
                                                        if ($row['father_status'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Mother's Status:</span>
                                                        <span class="text"><?php echo $row['mother_status'] ?></span>
                                                        <?php
                                                        if ($row['mother_status'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Total Member:</span>
                                                        <span class="text"><?php echo $row['total_member'] ?></span>
                                                        <?php
                                                        if ($row['total_member'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Family Type:</span>
                                                        <span class="text"><?php echo $row['family_type'] ?></span>
                                                        <?php
                                                        if ($row['family_type'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">About Family:</span>
                                                        <span class="text">
                                                            <?php echo $row['about_family'] ?>
                                                        </span>
                                                        <?php
                                                        if ($row['about_family'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Permanent Address</h3>
                                                <ul class="personal-info">

                                                    <li>
                                                        <span class="title">Permanent address:</span>
                                                        <span class="text"><?php echo $row['permanent_address'] ?></span>
                                                        <?php
                                                        if ($row['permanent_address'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Country:</span>
                                                        <span class="text"><?php echo $row['country'] ?></span>
                                                        <?php
                                                        if ($row['country'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Division:</span>
                                                        <span class="text"><?php echo $row['division'] ?></span>
                                                        <?php
                                                        if ($row['division'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">State:</span>
                                                        <span class="text"><?php echo $row['state'] ?></span>
                                                        <?php
                                                        if ($row['state'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Post Code:</span>
                                                        <span class="text"><?php echo $row['postal_code'] ?></span>
                                                        <?php
                                                        if ($row['postal_code'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Present Address</h3>
                                                <ul class="personal-info">

                                                    <li>
                                                        <span class="title">Present address:</span>
                                                        <span class="text"><?php echo $row['present_address'] ?></span>
                                                        <?php
                                                        if ($row['present_address'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Current country:</span>
                                                        <span class="text"><?php echo $row['current_country'] ?></span>
                                                        <?php
                                                        if ($row['current_country'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Current City:</span>
                                                        <span class="text"><?php echo $row['current_city'] ?></span>
                                                        <?php
                                                        if ($row['current_city'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Phone:</span>
                                                        <span class="text">
                                                            <?php
                                                            if ($phone->num_rows > 0) {
                                                                while ($rows = $phone->fetch_assoc()) {
                                                                    if ($rows['request_status'] == 1) {
                                                                        echo '<span style="color:orangered">Request Pending</span>';
                                                                    } elseif ($rows['is_accepted'] == 1) {
                                                                        echo $row['phone'];
                                                                        if ($row['phone'] == "") {
                                                                            echo "<br>";
                                                                        }
                                                                    } elseif ($rows['is_cancelled'] == 1) {
                                                                        ?>
                                                                        <form method="POST" action="">
                                                                            <input type="hidden" name="requested_for" value="email" />
                                                                            <input type="submit" style="border: none;background: none;outline: none;color:blue;cursor: pointer" name="request" value="Request For Email" />
                                                                        </form>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                ?>
                                                                <form method="POST" action="">
                                                                    <input type="hidden" name="requested_for" value="phone" />
                                                                    <input type="submit" style="border: none;background: none;outline: none;color:blue;cursor: pointer" name="request" value="Request For Phone" />
                                                                </form>
                                                            <?php }
                                                            ?>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="title">Email:</span>
                                                        <span class="text" style="">
                                                            <?php
                                                            if ($email->num_rows > 0) {
                                                                while ($rows = $email->fetch_assoc()) {
                                                                    if ($rows['request_status'] == 1) {
                                                                        echo '<span style="color:orangered">Request Pending</span>';
                                                                    } elseif ($rows['is_accepted'] == 1) {
                                                                        echo $row['email'];
                                                                        if ($row['email'] == "") {
                                                                            echo "<br>";
                                                                        }
                                                                    } elseif ($rows['is_cancelled'] == 1) {
                                                                        ?>
                                                                        <form method="POST" action="">
                                                                            <input type="hidden" name="requested_for" value="email" />
                                                                            <input type="submit" style="border: none;background: none;outline: none;color:blue;cursor: pointer" name="request" value="Request For Email" />
                                                                        </form>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                ?>
                                                                <form method="POST" action="">
                                                                    <input type="hidden" name="requested_for" value="email" />
                                                                    <input type="submit" style="border: none;background: none;outline: none;color:blue;cursor: pointer" name="request" value="Request For Email" />
                                                                </form>
                                                            <?php }
                                                            ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Education</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Highest Education:</span>
                                                        <span class="text"><?php echo $row['education'] ?></span>
                                                        <?php
                                                        if ($row['education'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Education Details:</span>
                                                        <span class="text"><?php echo $row['education_details'] ?></span>
                                                        <?php
                                                        if ($row['education_details'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Grade:</span>
                                                        <span class="text"></span>
                                                        <br>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Career</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Professional sector</span>
                                                        <span class="text"><?php echo $row['professional_sector'] ?></span>
                                                        <?php
                                                        if ($row['professional_sector'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Profession:</span>
                                                        <span class="text"><?php echo $row['profession'] ?></span>
                                                        <?php
                                                        if ($row['profession'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Income:</span>
                                                        <span class="text"><?php echo $row['income'] ?></span>
                                                        <?php
                                                        if ($row['income'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Physical Status</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Height:</span>
                                                        <span class="text"><?php echo $row['height'] ?></span>
                                                        <?php
                                                        if ($row['height'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Weight:</span>
                                                        <span class="text"><?php echo $row['weight'] ?></span>
                                                        <?php
                                                        if ($row['weight'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Physical Condition/ &nbsp;Problem/&nbsp;Issue</h3>
                                                <?php echo $row['physical_condition'] ?>
                                                <?php
                                                if ($row['physical_condition'] == "") {
                                                    echo "<br><br><br>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-box">
                                                <h3 class="card-title">Biography / Personal record</h3>
                                                <?php echo $row['biography'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

        <?php if ($request_sent === $request_limit) { ?>
            <div class="awesome-modal" id="modal"><a class="close-icon" href="#close"></a>
                <center>
                    <h3 class="modal-title text-danger">Sorry! You have reached your limit for sending request. Do you want to upgrade your profile?</h3>
                    <br>
                    <a class="btn btn-success" href="premium-packages.php">Yes</a>&emsp;||&emsp;<a class="btn btn-danger" href="#close" style="">No</a>
                </center>
            </div>
        <?php } ?>

        <?php include './parts/js-links.php'; ?>
        <?php if ($payment_status == 0) { ?>
            <script>
                $('img').bind('contextmenu', function (e) {
                    return false;
                });
            </script>
        <?php } ?>

    </body>
</html>