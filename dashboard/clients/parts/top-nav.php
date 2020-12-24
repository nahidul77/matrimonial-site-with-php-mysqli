<?php $expired = $server->package_expiration(); ?>
<?php $server->last_seen_at(); ?>

<div class="header-left">
    <a href="index.php" class="logo">
<img src="assets/img/heart.png" width="35" height="35" alt=""> <span>BrideBox</span>
    </a>
</div>
<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
<a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
<div>
<ul class="nav user-menu float-right">
    <li class="nav-item dropdown d-none d-sm-block">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right">0</span></a>
    </li>
    <li class="nav-item dropdown d-none d-sm-block" >
        <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <p id="unseen_from"><span class="badge badge-pill bg-danger float-right"><?php echo $server->total_unread_message(); ?></span></p></a>
    </li>
    <li class="nav-item dropdown has-arrow">
        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
            <span class="user-img">
                <img class="rounded-circle" style="height: 40px;width: 40px" src="<?php echo $row['propic']; ?>" width="24" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="">
                <span class="status online"></span>
            </span>
            <span><?php echo $row['first_name']; ?></span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="middleware.php">Logout</a>
        </div>
    </li>
</ul>
</div>
<div class="dropdown mobile-user-menu float-right">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="profile.php">My Profile</a>
        <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
        <a class="dropdown-item" href="#">Settings</a>
        <a class="dropdown-item" href="middleware.php">Logout</a>
    </div>
</div>