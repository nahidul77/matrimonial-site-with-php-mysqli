<?php $url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>

<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="<?php if ($url == 'index.php') { echo 'active';}?>" >
                <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-user"></i> <span>My Profile </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="profile.php" class="<?php if ($url == 'profile.php') { echo 'active';}?>">Profile Details</a></li>
                    <li><a href="update-profile.php" class="<?php if ($url == 'update-profile.php') { echo 'active';}?>">Update Profile</a></li>
                </ul>
            </li>
            <li class="<?php if ($url == 'search.php' || $url == 'search-results.php') { echo 'active';} ?>">
                <a href="search.php"><i class="fa fa-search"></i> <span>Find a match</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-user-plus"></i><span>Mutual People</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="requests.php" class="<?php if ($url == 'requests.php') {echo 'active';}?>">Requests</a></li>
                    <li><a href="connected-ones.php" class="<?php if ($url == 'connected-ones.php') {echo 'active';}?>">Connected</a></li>
                </ul>
            </li>
            <li class="<?php if ($url == 'profile-visitors.php') {echo 'active';}?>">
                <a href="profile-visitors.php"><i class="fa fa-users"></i> <span>Profile Visitors</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-money"></i> <span>Get Premium</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="verify-account.php" class="<?php if ($url == 'verify-account.php' || $url == 'nid-verification.php' || $url == 'passport-verification.php' ) {echo 'active';}?>">Verify Account</a></li>
                    <li><a href="verify-contact.php" class="<?php if ($url == 'verify-contact.php') {echo 'active';}?>">Verify Contact</a></li>
                    <li><a href="premium-packages.php" class="<?php if ($url == 'premium-packages.php') { echo 'active';}?>">Choose Package</a></li>
                    <li><a href="premium-history.php" class="<?php if ($url == 'premium-history.php') { echo 'active';}?>">Your Packages</a></li>
                </ul>
            </li>
            <li class="<?php if ($url == 'contact-requests.php') {echo 'active';}?>">
                <a href="contact-requests.php"><i class="fa fa-address-book"></i> <span>Contact Requests</span> 
                    <span class="badge badge-pill bg-primary float-right" >
                        <?php echo $server->total_contact_requests(); ?>
                    </span>
                </a>
            </li>
            
            <li class="submenu">
                <a href="#"><i class="fa fa-commenting-o"></i> <span>Messages</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="#">Send Message</a></li>
                    <li><a href="#">Sent Messages</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-flag-o"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="#"> Report  </a></li>
                    <li><a href="#"> History </a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a>
            </li>
        </ul>
    </div>
</div>