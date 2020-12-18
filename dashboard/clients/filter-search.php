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
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <a class="avatar" href="profile.html">B</a>
                                                        <h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
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
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <a class="avatar" href="profile.html">B</a>
                                                        <h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
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
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <a class="avatar" href="profile.html">B</a>
                                                        <h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
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
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <a class="avatar" href="profile.html">B</a>
                                                        <h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
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
                                                <tr>
                                                    <td style="min-width: 200px;">
                                                        <a class="avatar" href="profile.html">B</a>
                                                        <h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
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