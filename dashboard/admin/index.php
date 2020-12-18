<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$admin_id = $_SESSION['admin_id'];

require_once './server/Admin.php';
$result = "";


$server = new Admin();
$result = $server->adminData();
$active = $server->ViewActiveClients();
$blocked = $server->ViewBlockedClients();
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

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <a href="clients.php">
                                <div class="dash-widget">
                                    <span class="dash-widget-bg1"><i class="fa fa-users" aria-hidden="true"></i></span>
                                    <div class="dash-widget-info text-right">
                                        <h3><?php echo $server->total_clients() ?></h3>
                                        <span class="widget-title1">Clients <i class="fa fa-check" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <a href="premium-clients.php">
                            <div class="dash-widget">
                                <span class="dash-widget-bg2"><i class="fa fa-money"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $server->total_premium_clients() ?></h3>
                                    <span class="widget-title2">Premium Client <i class="fa fa-check" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <a href="clients-by-gender.php?gender=Male">
                            <div class="dash-widget">
                                <span class="dash-widget-bg3"><i class="fa fa-male" aria-hidden="true"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $server->total_male_clients() ?></h3>
                                    <span class="widget-title3">Male Clients <i class="fa fa-check" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                             <a href="clients-by-gender.php?gender=Female">
                            <div class="dash-widget">
                                <span class="dash-widget-bg4"><i class="fa fa-female" aria-hidden="true"></i></span>
                                <div class="dash-widget-info text-right">
                                    <h3><?php echo $server->total_female_clients() ?></h3>
                                    <span class="widget-title4">Female Clients <i class="fa fa-check" aria-hidden="true"></i></span>
                                </div>
                            </div>
                             </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block text-success">Total active clients [ <?php echo $server->total_active_clients(); ?> ]</h4> <a href="active-clients.php" class="btn btn-primary float-right">View all</a>
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
                                                                <a class="avatar" href="client-profile.php?client_id=<?php echo $row['client_id'] ?>"><img src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/></a>
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
                                                                <h5 class="time-title p-0">Joining Date</h5>
                                                                <p><?php echo $row['joining_date'] ?></p>
                                                            </td>
                                                            <td class="text-right">
                                                                <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>" target="" class="btn btn-outline-primary take-btn">Take up</a>
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
                            <div class="card member-panel">
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0 text-danger">Blocked Clients [ <?php echo $server->total_blocked_clients(); ?> ]</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="contact-list">
                                        <?php
                                        if ($blocked->num_rows > 0) {
                                            while ($row = $blocked->fetch_assoc()) {
                                                ?>
                                                <li>
                                                    <div class="contact-cont">
                                                        <div class="float-left user-img m-r-10">
                                                            <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>" ><img src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" class="w-40 rounded-circle"><span class="status offline"></span></a>
                                                        </div>
                                                        <div class="contact-info">
                                                            <span class="contact-name text-ellipsis"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></span>
                                                            <span class="contact-date"><?php echo $row['current_city'] ?>, <?php echo $row['current_country'] ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <div class="contact-cont text-danger">

                                                </div>
                                            </li>
                                        <?php }
                                        ?>
                                    </ul>
                                </div>
                                <div class="card-footer text-center bg-white">
                                    <a href="blocked-clients.php" class="text-muted">View all Blocked.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">Clients by religions</h4> 
                                </div>
                                <div class="card-body p-0" style="min-height: 319px;max-height: 319px;overflow: auto">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>

                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Islam</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Islam') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Islam') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Islam') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=Islam" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Christianity</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Christianity') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Christianity') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Christianity') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=Christianity" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Judaism</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Judaism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Judaism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Judaism') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=Judaism" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Hinduism</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Hinduism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Hinduism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Hinduism') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=Hinduism" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Buddhism</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Buddhism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Buddhism') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Buddhism') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=Buddhism" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Atheist</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Atheist') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Atheist') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Atheist') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="time-title p-0">Religion Name</h5>
                                                        <p>Other</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Male</h5>
                                                        <p><?php echo $server->total_clients_by('Male', 'Other') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Female</h5>
                                                        <p><?php echo $server->total_clients_by('Female', 'Other') ?></p>
                                                    </td>
                                                    <td>
                                                        <h5 class="time-title p-0">Total</h5>
                                                        <p><?php echo $server->total_clients_byReligion('Other') ?></p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="clients-by-religion.php?religion=" target="" class="btn btn-outline-primary take-btn">Take up</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="card member-panel" >
                                <div class="card-header bg-white">
                                    <h4 class="card-title mb-0">ADD SECTION</h4>
                                </div>
                                <div class="card-body" style="min-height: 319px;max-height: 319px">
                                    
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