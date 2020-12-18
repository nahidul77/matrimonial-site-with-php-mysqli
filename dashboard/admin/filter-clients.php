<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$admin_id = $_SESSION['admin_id'];

require_once './server/Admin.php';
$result = "";
$data = "";

$server = new Admin();
$result = $server->adminData();

$data = $server->ViewAllClients();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>

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
            <?php } ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6 col-3">
                            <h4 class="page-title"><u>Client Profile</u></h4>
                        </div>
                        <div class="col-sm-6 col-9 text-right m-b-20">
                            <a href="clients.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-users"></i> All Clients</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="appointments.html" class="btn btn-primary float-right">View all</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="d-none">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Doctor Name</th>
                                                    <th>Timing</th>
                                                    <th class="text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($data->num_rows > 0) {
                                                    while ($row = $data->fetch_assoc()) {
                                                        ?> 
                                                        <tr>
                                                            <td style="min-width: 200px;">
                                                                <a class="avatar" href="profile.html"><img src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt=""/></a>
                                                                <h2><a href="profile.html"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></a></h2>
                                                            </td>                 
                                                            <td>
                                                                <h5 class="time-title p-0">Appointment With</h5>
                                                                <p>Dr. Cristina Groves</p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Timing</h5>
                                                                <p>7.00 PM</p>
                                                            </td>
                                                            <td class="text-right">
                                                                <a href="appointments.html" class="btn btn-outline-primary take-btn">Take up</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                <div class="col-md-12 col-sm-12  col-lg-12">
                                                    <div class="profile-widget">
                                                        <center>
                                                            <img alt="" src="../gallery/NoRecordFound.jpg" alt="" style="height: 100%;width: 100%">
                                                        </center>
                                                    </div>
                                                </div>
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
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>

    </body>
</html>