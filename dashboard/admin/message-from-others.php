<?php
session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}
require_once './server/Admin.php';
$result = '';
$delete = '';
$change = '';
$data = '';

$server = new Admin();
$result = $server->messages_FromOthers();

$data = $server->adminData();

if (isset($_POST['delete'])) {
    $delete = $server->delete_message($_POST);
}
if (isset($_POST['change'])) {
    $change = $server->changeMessage_status($_POST);
}
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
            <?php while ($row = $data->fetch_assoc()) { ?>
                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>

                <div class="sidebar" id="sidebar">
                    <?php include './parts/side-nav.php'; ?>
                </div>
            <?php } ?>

            <?php echo $change; ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-8 col-3">
                            <b><h4 class=""><u>MESSAGE FROM OTHERS</u>&emsp;[ <span style="color:orangered"><?php echo $server->total_unreadMessage(); ?></span> ]</h4></b>
                        </div>
                        <div class="col-sm-4 col-9 text-right m-b-20">
                            <a href="#" class="btn btn-primary btn-rounded float-right"><i class="fa fa-envelope"></i> Client Messages</a>
                        </div>
                    </div>
                    <div class="row doctor-grid">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="col-sm-6">
                                    <div class="profile-widget" style="min-height: 200px;text-align: justify; text-justify: inter-word;">
                                        
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['message_id'] ?>" name="message_id"/>
                                                    <?php if ($row['is_seen'] == 1) { ?>
                                                        <input type="hidden" value="0" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-times-circle m-r-5"></i> Mark as Unread.
                                                        </button>
                                                    <?php } else {
                                                        ?>
                                                        <input type="hidden" value="1" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change"  style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-check-circle m-r-5"></i>Mark as Read.
                                                        </button>
                                                    <?php }
                                                    ?>
                                                    <button type="submit" class="dropdown-item" name="delete" style="border: none;background: none;outline: none;width:100%;cursor: pointer" onclick="return confirm('Are you sure?');">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </button>
                                                </form>

                                            </div>
                                    </div>
                                        <div style="max-height: 300px;overflow: auto">
                                        <h3>From: <?php echo $row['message_from'] ?>[<?php if ($row['is_seen'] == 1){echo '<span style="color:green">seen</span>';}else{echo '<span style="color:red">unseen</span>';} ?>]</h3>
                                        <h4>Phone/Email: &nbsp;<?php echo $row['contact'] ?></h4>
                                        <h4><mark><?php echo $row['subject'] ?></mark></h4>
                                        <small><?php echo $row['date'] ?></small>
                                        <h4><?php echo $row['message'] ?></h4>
                                        </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12 col-sm-12  col-lg-12">
                                <div class="profile-widget">
                                    <center>
                                        <img alt="" src="../gallery/nodata-found.png" alt="" style="height: 100%;width: 100%">
                                    </center>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>

                <?php include './parts/messages.php'; ?>

            </div>

        </div>
        <div class="sidebar-overlay" data-reff=""></div>

        <!--scripts-->
        <?php include './parts/js-links.php'; ?>

    </body>


</html>