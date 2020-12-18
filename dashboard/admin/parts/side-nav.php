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
                <a href="search.php"><i class="fa fa-search"></i> <span>Search</span></a>
            </li>
             <li class="submenu">
                <a href="#"><i class="fa fa-user"></i> <span>Clients</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="clients.php" class="<?php if ($url == 'clients.php' || $url == 'client-profile.php') {echo 'active';}?>">View Clients</a></li>
               </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-paper-plane"></i> <span>Requests</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="verification-requests.php" class="<?php if ($url == 'verification-requests.php' ) {echo 'active';}?>">Account Verification</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-cubes"></i> <span>Packages</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="new-package.php" class="<?php if ($url == 'new-package.php') {echo 'active';}?>">New Package</a></li>
                    <li><a href="packages.php" class="<?php if ($url == 'packages.php') {echo 'active';}?>">View Packages</a></li>
                    <li><a href="#" class="<?php if ($url == 'update-package.php') {echo 'active';}?>">Update Packages</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-envelope"></i> <span>Messages</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="#" class="<?php if ($url == 'message-from-cients.php') {echo 'active';}?>">From Clients</a></li>
                    <li><a href="message-from-others.php" class="<?php if ($url == 'message-from-others.php') {echo 'active';}?>">From Others</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-comments"></i> <span>Chat</span> <span class="badge badge-pill bg-primary float-right">0</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="#">Blog</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-gift"></i> <span>Offers</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
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