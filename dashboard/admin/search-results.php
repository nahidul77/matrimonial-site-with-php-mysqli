<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$admin_id = $_SESSION['admin_id'];

require_once './server/Admin.php';
$result = "";
$output = "";

$server = new Admin();
$result = $server->adminData();

if (isset($_POST['search'])) {
    $output = $server->searchProfiles($_POST);
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
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                <u>SEARCH RESULTS</u>&nbsp;<i class="fa fa-users"></i>
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
                                            $string = $row['biography'];
                                            if (strlen($string) > 100) {
                                                $trimstring = substr($string, 0, 100) . ' <a href="client-profile.php?client_id='.$row['client_id'].'" target="_blank">read more...</a>';
                                            } else {
                                                $trimstring = $string;
                                            }
                                            echo $trimstring;
                                            ?>
                                        </div>
                                        <div class="col-sm-1">
                                            <table>
                                                <tr>
                                                    <td><a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>" target="_blank" class="btn btn-primary" title="Profile" style="width: 60px"><i class="fa fa-user"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></td>
                                                </tr>
                                           </table>
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
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script>
            $('img').bind('contextmenu', function (e) {
                return false;
            });
        </script>

    </body>
</html>