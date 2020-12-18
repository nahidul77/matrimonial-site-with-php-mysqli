<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$admim_id = $_SESSION['admin_id'];

require_once './server/Admin.php';
$result = "";

$server = new Admin();
$result = $server->adminData();
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
            .title{
                /*text-decoration: underline*/
            }
        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>
                <div class="sidebar" id="sidebar">
                    <?php include './parts/side-nav.php'; ?>
                </div>

                <?php
                if ($row['status'] == 0) {
                    echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
                }
                ?>
                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-6 col-3">
                                <h4 class="page-title"><u>My Profile</u></h4>
                            </div>
                            <div class="col-sm-6 col-9 text-right m-b-20">
                                <form method="POST" action="update-profile.php">
                                    <input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>" required/>
                                    <button name="show" class="btn btn-primary btn-rounded float-right"><i class="fa fa-pencil"></i> Edit Profile</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-box profile-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap" >
                                            <div class="profile-img">
                                                <a href="<?php echo $row['propic'] ?>" target="_blank"><img class="" src="<?php echo $row['propic'] ?>"  onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic" style="min-height: 150px">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="">
                                                        <h3 class="user-name m-t-0 mb-0"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h3>
                                                        <small class="text-muted"><?php echo $row['type'] ?></small>
                                                        <h4>ID:<?php echo $row['admin_id'] ?></h4>
                                                    </div>
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
                                                            <span class="title">Username:</span>
                                                            <span class="text"><a href="#"><?php echo $row['username'] ?></a></span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Password:</span>
                                                            <span class="text">
                                                                <input type="password" id="password" value="<?php echo $row['password'] ?>" style="border:none;background: none;outline: none;" readonly/>
                                                                <button class="btn-danger" onclick="if (password.type == 'text')
                                                                            password.type = 'password';
                                                                        else
                                                                            password.type = 'text';"><i class="fa fa-eye"></i></button>
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
            <?php } ?>
        </div>
        <?php include './parts/js-links.php'; ?>
        

    </body>
</html>